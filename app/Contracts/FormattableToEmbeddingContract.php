<?php

namespace App\Contracts;

interface FormattableToEmbeddingContract
{
    public function build(EmbeddableContract $embeddable, $depth = 0): array;

    public function format(array $message): string;
}