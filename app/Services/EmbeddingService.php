<?php

namespace App\Services;

use App\Reducers\EmbeddingReducer;
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
                'model' => 'llama3-chatqa',
                'input' => $content,
            ]);

        $data = $response->json();

        $embedding = $data['data'][0]['embedding'] ?? null;

        if (!$embedding) {
            throw new Exception('Failed to generate embedding');
        }

        $reduced_embedding = EmbeddingReducer::reduce_vector($embedding, 1024);

        return $reduced_embedding;
    }
}