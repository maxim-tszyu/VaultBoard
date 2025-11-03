<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    public function build(string $content)
    {
        $response = Http::timeout(40)
            ->retry(3, 2000)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('http://ollama:11434/v1/embeddings', [
                'model' => 'bge-m3:latest',
                'input' => $content,
            ]);

        $data = $response->json();

        $embedding = $data['data'][0]['embedding'] ?? null;

        if (!$embedding) {
            throw new Exception('Failed to generate embedding');
        }

        $norm = sqrt(array_reduce($embedding, fn($carry, $val) => $carry + $val ** 2, 0));
        $normalized = array_map(fn($val) => $val / $norm, $embedding);

        return $normalized;
    }
}