<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Pgvector\Laravel\Distance;
use Throwable;

class TaskReportPayloadService
{
    public function __construct(private LogReportPayloadService $logService)
    {
        Log::info('there is an ai report payload');
    }

    public function build(Task $task, $depth = 0)
    {
        $similar_tasks_info = $depth === 0
            ? $task->nearestNeighbors('embedding', Distance::Cosine)
                ->where('user_id', '=', $task->user->id)
                ->take(5)
                ->get()
                ->where('neighbor_distance', '<=', 0.40)
                ->sortBy('neighbor_distance')
                ->take(3)
                ->map(fn($t) => $this->buildMessage([
                    'title' => $t->title,
                    'status' => $t->status,
                    'priority' => $t->priority,
                    'created_at' => $t->created_at->toDateTimeString(),
                    'deadline' => $t->due_date?->toDateString(),
                    'description' => $t->description,
                ]))
            : null;
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
            'very_similar_tasks' => $similar_tasks_info ? implode(', ', $similar_tasks_info->all()) : null,
            'children_tasks' => $depth === 0
                ? implode(
                    ', ',
                    $task->subtasks->map(fn($child) => $this->buildMessage($this->build($child, $depth + 1)))->all()
                )
                : 'There are no children',
        ];
    }

    public function buildMessage($message)
    {
        $result = '';
        foreach ($message as $key => $value) {
            try {
                $result .= "**{$key}:** {$value}\n";
            } catch (Throwable $th) {
                dd($message);
            }
        }

        return $result;
    }
}
