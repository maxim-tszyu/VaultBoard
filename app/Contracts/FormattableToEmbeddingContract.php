<?php

namespace App\Contracts;

interface FormattableToEmbeddingContract
{
    public function build(EmbeddableContract $embeddable): string;
}