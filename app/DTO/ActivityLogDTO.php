<?php

namespace App\DTO;

use Carbon\Carbon;

class ActivityLogDTO
{
    public function __construct(
        public int $task_id,
        public string $title,
        public string $content,
        public string $started_at,
        public string $ended_at,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            task_id: $request->task_id,
            title: $request->title,
            content: $request->content,
            started_at: Carbon::parse($request->started_at)->utc()->toDateTimeString(),
            ended_at: Carbon::parse($request->ended_at)->utc()->toDateTimeString(),
        );
    }
}
