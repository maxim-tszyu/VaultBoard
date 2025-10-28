<?php

namespace App\Contracts;

interface EmbeddableContract
{
    public function getEmbeddingContent();

    public function saveEmbeddingContent(array $embedding);
}