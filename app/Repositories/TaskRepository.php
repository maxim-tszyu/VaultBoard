<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository
{
    public static function findAll(): Collection
    {
        return Task::where('user_id', auth()->id())->get();
    }
}
