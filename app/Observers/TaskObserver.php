<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updating(Task $task): void
    {
        if ($task->isDirty('status')) {
            if ($task->status === 'Active') {
                $task->started_at = now();
            } elseif ($task->status === 'Completed') {
                $task->completed_at = now();
            } elseif ($task->status === 'Aborted') {
                $task->abotred_at = now();
            }
        }
    }

    public function updated(Task $task): void
    {
        Cache::forget("ai_report_task_{$task->id}");
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
