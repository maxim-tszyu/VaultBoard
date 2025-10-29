<?php

namespace App\Reducers;

class EmbeddingReducer
{
    public static function reduce_vector(array $vector, int $targetDim): array
    {
        $originalLength = count($vector);

        if ($targetDim >= $originalLength) {
            return array_slice($vector, 0, $targetDim);
        }

        $chunkSize = ceil($originalLength / $targetDim);

        $chunks = array_chunk($vector, $chunkSize);

        $reduced = array_map(function ($chunk) {
            return array_sum($chunk) / count($chunk);
        }, array_slice($chunks, 0, $targetDim));

        return $reduced;
    }
}