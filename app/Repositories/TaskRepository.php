<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Pgvector\Laravel\Distance;

class TaskRepository
{
    public static function findAllTasksBelongingToUser(): Collection
    {
        return Task::where('user_id', auth()->id())->get();
    }

    public static function findAllUrgentTasksBelongingToUser(): Collection
    {
        return Task::where('user_id', auth()->id())
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<=', now()->addDays(3))
            ->get();
    }

    public static function findAllPriorityTasksBelongingToUser(): Collection
    {
        return Task::where('user_id', auth()->id())
            ->where('priority', 'High')
            ->get();
    }

    public static function findNearTasksBelongingToTask(Task $task): Collection
    {
        $neighbor = $task->nearestNeighbors('embedding', Distance::Cosine)->take(2)->get();
        return $neighbor;
    }
}
