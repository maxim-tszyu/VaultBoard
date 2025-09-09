<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use Illuminate\Support\Collection;

class ActivityLogRepository
{
    public static function findAllBelongingToUser(): Collection
    {
        return ActivityLog::where('user_id', auth()->id())->get();
    }
}
