<?php

use App\Enums\Status;
use App\Jobs\FailTaskJob;
use App\Models\Task;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
    Task::where('due_date', '<=', now())
        ->whereNot('status', Status::ABORTED->value)
        ->each(function (Task $task) {
            FailTaskJob::dispatch($task->id);
        });
})->everyMinute();