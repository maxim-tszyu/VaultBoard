<?php

namespace App\Jobs;

use App\Events\AiReportGeneratedEvent;
use App\Models\Task;
use App\Services\LogReportPayloadService;
use App\Services\TaskReportPayloadService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GenerateAiReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $taskId) {}

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
        if ($response->successful()) {
            $data = $response->json();
            $text_array = $data['candidates'][0]['content']['parts'][0];
            Cache::put("ai_report_task_{$this->taskId}", $text_array, now()->addHour());
            event(new AiReportGeneratedEvent($task->id, $text_array));
        } else {
            dd('fail');
        }

    }
}
