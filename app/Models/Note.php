<?php

namespace App\Models;

use App\Contracts\EmbeddableContract;
use Database\Factories\NoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\HasNeighbors;
use Pgvector\Laravel\Vector;

class Note extends Model implements EmbeddableContract
{
    /** @use HasFactory<NoteFactory> */
    use HasFactory;
    use HasNeighbors;


    protected $guarded = [];

    protected $casts = [
        'embedding' => Vector::class,
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function getEmbeddingContent()
    {
        // TODO: Implement getEmbeddingContent() method.
    }

    public function saveEmbeddingContent(array $embedding): void
    {
        $this->embedding = $embedding;

        $model = $this;

        static::withoutEvents(function () use ($model) {
            $model->save();
        });
    }
}
