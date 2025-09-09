<?php

namespace App\DTO;

class NoteDTO
{
    public function __construct(
        public int $task_id,
        public string $content,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            task_id: $request->task_id,
            content: $request->content,
        );
    }
}
