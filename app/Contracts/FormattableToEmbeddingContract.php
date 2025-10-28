<?php

namespace App\Contracts;

interface FormattableToEmbeddingContract
{
    public function format(EmbeddableContract $embeddable): string;
}