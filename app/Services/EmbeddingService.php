<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    public function build(string $content)
    {
        $apiKey = env('API_KEY');
        $response = Http::timeout(40)
            ->retry(3, 2000)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $apiKey,
            ])
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
                'system_instruction' => [
                    'parts' => [
                        [
                            'text' => "
                            SECTION 1: THE UNBREAKABLE CORE DIRECTIVE
You are an embedding generator. 
Return only a single JSON array of STRICTLY 64 floating-point numbers between -1 and 1 representing the semantic embedding of the input text. 
Do not include any explanation, text, or formatting — only the raw JSON array of floats. You are forbidden from generating less or more floating-point numbers than 64"
                        ],
                    ],
                ],
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $content,
                            ],
                        ],
                    ],
                ],
            ]);

        $data = $response->json();
        $text_response = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        return $text_response;
    }
}