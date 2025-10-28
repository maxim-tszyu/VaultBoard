<?php

namespace App\Formatters;


use App\Contracts\EmbeddableContract;
use App\Contracts\FormattableToEmbeddingContract;

class TaskFormatter implements FormattableToEmbeddingContract
{
    public function format(EmbeddableContract $embeddable): string
    {
        return 'Example text';
    }
}