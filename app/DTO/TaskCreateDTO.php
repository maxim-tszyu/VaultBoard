<?php

namespace App\DTO;

use App\Enums\Priority;
use Carbon\Carbon;

class TaskCreateDTO
{
    public function __construct(
        public ?int $parent_task_id,
        public string $title,
        public ?string $description,
        public Carbon $due_date,
        public Priority $priority,
        public array $category_ids = []
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            parent_task_id: $request->parent_task_id,
            title: $request->title,
            description: $request->description,
            due_date: Carbon::parse($request->due_date),
            priority: Priority::from($request->priority),
            category_ids: $request->category_ids ?? []
        );
    }
}
