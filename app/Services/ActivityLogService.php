<?php

namespace App\Services;

use App\DTO\ActivityLogDTO;
use App\Models\ActivityLog;
use App\Repositories\ActivityLogRepository;

class ActivityLogService
{
    public function __construct(
        private ActivityLogRepository $activityLogRepository
    ) {}

    public function index()
    {
        return $this->activityLogRepository->findAllBelongingToUser();
    }

    public function store(ActivityLogDTO $activityLogDTO)
    {
        ActivityLog::create([
            'task_id' => $activityLogDTO->task_id,
            'title' => $activityLogDTO->title,
            'content' => $activityLogDTO->content,
            'started_at' => $activityLogDTO->started_at,
            'ended_at' => $activityLogDTO->ended_at,
        ]);
    }
}
