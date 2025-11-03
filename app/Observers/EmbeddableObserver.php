<?php

namespace App\Observers;

use App\Contracts\EmbeddableContract;
use App\Factories\EmbeddingFactory;
use App\Jobs\GenerateEmbeddingJob;

class EmbeddableObserver
{
    public function saved(EmbeddableContract $model): void
    {
        $formatter = EmbeddingFactory::make($model);
        $formatted = $formatter->build($model);

        dispatch(new GenerateEmbeddingJob(
            formatted: $formatted,
            modelClass: get_class($model),
            id: $model->id
        ));
    }

}
