<?php

namespace App\Jobs;

use App\Contracts\EmbeddableContract;
use App\Services\EmbeddingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Throwable;

class GenerateEmbeddingJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function __construct(
        public string $formatted,
        public string $modelClass,
        public int $id
    ) {
        \Illuminate\Support\Facades\Log::info('Variable type: ' . gettype($formatted));
        \Illuminate\Support\Facades\Log::info('Variable type: ' . gettype($modelClass));
    }

    public function handle(EmbeddingService $service): void
    {
        if (!in_array(EmbeddableContract::class, class_implements($this->modelClass))) {
            Log::warning("GenerateEmbeddingJob: {$this->modelClass} не реализует EmbeddableContract");
            return;
        }

        /** @var EmbeddableContract|null $model */
        $model = $this->modelClass::find($this->id);

        if (!$model) {
            Log::warning("GenerateEmbeddingJob: модель {$this->modelClass} с id={$this->id} не найдена");
            return;
        }

        try {
            $embedding = $service->build($this->formatted);
            Log::info("Embedding generated for {$this->modelClass}#{$this->id}", [
                'embedding_sample' => substr(json_encode($embedding), 0, 200) . '...',
            ]);

            $model->saveEmbeddingContent($embedding);
        } catch (Throwable $e) {
            Log::error('GenerateEmbeddingJob failed', [
                'model' => $this->modelClass,
                'id' => $this->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
