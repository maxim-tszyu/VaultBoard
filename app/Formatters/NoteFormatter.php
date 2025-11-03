<?php

namespace App\Formatters;

use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;

class NoteFormatter implements FormattableToEmbeddingContract
{
    public function build(EmbeddableContract $embeddable, $depth = 0): string
    {
        $parts = [];

        if (!empty($embeddable->content)) {
            $parts[] = $embeddable->content;
        }

        if ($embeddable->task) {
            $parts[] = "Task title: " . $embeddable->task->title;
            if (!empty($embeddable->task->description)) {
                $parts[] = "Task description: " . $embeddable->task->description;
            }
        }

        return implode('. ', $parts);
    }
}
