<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AiReportGeneratedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $taskId,
        public array $report
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('task.'.$this->taskId)];
    }

    public function broadcastWith(): array
    {
        $payload = [
            'taskId' => $this->taskId,
            'text' => $this->report['text'],
        ];

        $size = strlen(json_encode($payload));
        Log::info("Broadcast payload size: {$size} bytes");
        Log::info("Broadcast payload content: {$payload['text']}");

        return $payload;
    }
}
