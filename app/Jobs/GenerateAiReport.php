<?php

namespace App\Jobs;

use App\Events\AiReportGeneratedEvent;
use App\Models\Task;
use App\Services\LogReportPayloadService;
use App\Services\TaskReportPayloadService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateAiReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $taskId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = Task::find($this->taskId);

        $service = new TaskReportPayloadService(new LogReportPayloadService);
        $apiKey = env('API_KEY');
        $prompt = file_get_contents(resource_path(env('PROMPT_PATH')));

        $task_content = ($service->build($task));
        $text = ($service->buildMessage($task_content));
        try {
            $response = Http::timeout(10)
                ->retry(10, function ($attempt) {
                    return $attempt * 1000;
                })
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $apiKey,
                ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                    'system_instruction' => [
                        'parts' => [
                            'text' => $prompt,
                        ],
                    ],
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $text,
                                ],
                            ],
                        ],
                    ],
                ]);
        } catch (Throwable $e) {
            Log::error("AI REQUEST FAILED:", [
                'error' => $e->getMessage(),
            ]);
            $data = null;
        }
        if ($response->successful()) {
            $data = $response->json();

            try {
                $text_response = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if (!$text_response) {
                    throw new Exception('Missing AI response text');
                }

                Cache::put("ai_report_task_{$this->taskId}", $text_response, now()->addHour());
                event(new AiReportGeneratedEvent($task->id, $text_response));
            } catch (Throwable $e) {
                Log::warning('AI REPORT: invalid response structure', [
                    'response' => $data,
                    'error' => $e->getMessage(),
                ]);

                event(new AiReportGeneratedEvent($task->id, 'failed'));
            }
        } else {
            Log::error('AI REPORT: request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            event(new AiReportGeneratedEvent($task->id, 'failed'));
        }
    }
}
