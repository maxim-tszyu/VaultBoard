<?php

namespace App\Services;

use App\Models\ActivityLog;

class LogReportPayloadService
{
    public function build(ActivityLog $log)
    {
        return "Title: $log->title, Content: $log->content, Time logged: $log->started_at - $log->ended_at";
    }
}
