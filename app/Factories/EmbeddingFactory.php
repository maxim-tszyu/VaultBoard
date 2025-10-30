<?php

namespace App\Factories;

use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;
use App\Formatters\NoteFormatter;
use App\Formatters\TaskFormatter;
use App\Models\Note;
use App\Models\Task;
use Exception;

class EmbeddingFactory
{
    public static function make(EmbeddableContract $model): FormattableToEmbeddingContract
    {
        return match (get_class($model)) {
            Task::class => app(TaskFormatter::class),
            Note::class => app(NoteFormatter::class),
            default => throw new Exception("No formatter for model " . get_class($model))
        };
    }
}
