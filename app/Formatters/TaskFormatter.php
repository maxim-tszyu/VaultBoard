<?php

namespace App\Formatters;

use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;

class TaskFormatter implements FormattableToEmbeddingContract
{
    public function build(EmbeddableContract $embeddable): string
    {
        $parts = [];

        if (!empty($embeddable->title)) {
            $parts[] = $embeddable->title;
        }

        if (!empty($embeddable->description)) {
            $parts[] = $embeddable->description;
        }

        if ($embeddable->notes->isNotEmpty()) {
            $notesText = implode('. ', $embeddable->notes->pluck('content')->all());
            $parts[] = $notesText;
        }

        return implode('. ', $parts);
    }
}
