<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiReportGeneratedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $taskId,
        public string $report
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('task.'.$this->taskId)];
    }

    public function broadcastWith(): array
    {
        $payload = [
            'taskId' => $this->taskId,
            'text' => $this->report,
        ];

        $size = strlen(json_encode($payload));

        Log::info("Broadcast payload size: {$size} bytes");

        Log::debug('Broadcast payload preview', [
            'taskId' => $this->taskId,
            'text_sample' => Str::limit($this->report, 200, '...'),
        ]);

        return $payload;
    }
}
