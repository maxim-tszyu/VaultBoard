<?php

namespace App\Jobs;

use App\Enums\Status;
use App\Models\Task;
use App\Notifications\TaskFailedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FailTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = Task::find($this->taskId);
        $task->status = Status::ABORTED;
        $task->save();
        $task->user->notify(new TaskFailedNotification($task->id));
    }
}
