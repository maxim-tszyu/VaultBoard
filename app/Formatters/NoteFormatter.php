<?php

namespace App\Formatters;

use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;

class NoteFormatter implements FormattableToEmbeddingContract
{
    public function format(EmbeddableContract $embeddable): string
    {
        return '';
    }
}