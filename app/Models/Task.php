<?php

namespace App\Models;

use App\Contracts\EmbeddableContract;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\HasNeighbors;
use Pgvector\Laravel\Vector;

class Task extends Model implements EmbeddableContract
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;
    use HasNeighbors;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'embedding' => Vector::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function activity_logs()
    {
        return $this->hasMany(ActivityLog::class);
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
