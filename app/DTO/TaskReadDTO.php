<?php

namespace App\DTO;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Task;
use Carbon\Carbon;

class TaskReadDTO
{
    public function __construct(
        public int $id,
        public ?int $parent_task_id,
        public string $title,
        public ?string $description,
        public Carbon $due_date,
        public Status $status,
        public Priority $priority,
        public array $categories,
    ) {}

    public static function fromModel(Task $task): self
    {
        return new self(
            id: $task->id,
            parent_task_id: $task->parent_task_id,
            title: $task->title,
            description: $task->description,
            due_date: $task->due_date,
            status: $task->status,
            priority: $task->priority,
            categories: $task->categories
                ->pluck('name', 'id')
                ->toArray()
        );
    }
}
