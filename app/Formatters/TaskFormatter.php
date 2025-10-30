<?php

namespace App\Formatters;


use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;
use App\Services\LogReportPayloadService;
use Throwable;

class TaskFormatter implements FormattableToEmbeddingContract
{
    public function __construct(private LogReportPayloadService $logService)
    {
    }

    public function build(EmbeddableContract $embeddable, $depth = 0): array
    {
        return [
            'title' => $embeddable->title,
            'status' => $embeddable->status,
            'priority' => $embeddable->priority,
            'created_at' => $embeddable->created_at->toDateTimeString(),
            'deadline' => $embeddable->due_date?->toDateString(),
            'description' => $embeddable->description,
            'today' => now()->toDateString(),
            'logs' => implode(
                ', ',
                $embeddable->activity_logs->map(function ($log) {
                    return $this->logService->build($log);
                })->all()
            ),
            'notes' => implode(', ', $embeddable->notes->pluck('content')->all()),
            'parent_task' => $depth === 0 && $embeddable->parent
                ? $this->buildMessage($this->build($embeddable->parent, $depth + 1))
                : null,
            'children' => $depth === 0
                ? implode(', ',
                    $embeddable->subtasks->map(fn($child) => $this->buildMessage($this->build($child, $depth + 1))
                    )->all()
                )
                : 'There are no children',
        ];
    }

    public function format($message): string
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