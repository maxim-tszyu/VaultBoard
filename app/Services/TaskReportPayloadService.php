<?php

namespace App\Services;

use App\Models\Task;

class TaskReportPayloadService
{
    public function __construct(private LogReportPayloadService $logService) {}

    public function build(Task $task, $depth = 0)
    {
        return [
            'title' => $task->title,
            'status' => $task->status,
            'priority' => $task->priority,
            'created_at' => $task->created_at->toDateTimeString(),
            'deadline' => $task->due_date?->toDateString(),
            'description' => $task->description,
            'today' => now()->toDateString(),
            'logs' => implode(
                ', ',
                $task->activity_logs->map(function ($log) {
                    return $this->logService->build($log);
                })->all()
            ),
            'notes' => implode(', ', $task->notes->pluck('content')->all()),
            'parent_task' => $depth === 0 && $task->parent
                ? $this->buildMessage($this->build($task->parent, $depth + 1))
                : null,
            'children' => $depth === 0
                ? implode(', ', $task->subtasks->map(fn ($child) => $this->buildMessage($this->build($child, $depth + 1)))->all())
                : 'There are no children',
        ];
    }

    public function buildMessage($message)
    {
        $result = '';
        foreach ($message as $key => $value) {
            try {
                $result .= "**{$key}:** {$value}\n";
            } catch (\Throwable $th) {
                dd($message);
            }
        }

        return $result;
    }
}
