<?php

namespace App\Formatters;


use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;
use App\Services\LogReportPayloadService;
use Throwable;

class NoteFormatter implements FormattableToEmbeddingContract
{
    public function __construct(private LogReportPayloadService $logService)
    {
    }

    public function build(EmbeddableContract $embeddable, $depth = 0): array
    {
        return [
            'content' => $embeddable->content,
            'belongs_to' => $embeddable->task
                ? $embeddable->task->title
                : 'This note is not assigned to any task',
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