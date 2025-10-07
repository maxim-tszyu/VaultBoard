<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $userId = $request->user()->id;
        $tasks = Task::where('user_id', $userId)->get();
        $priorityTasks = Task::where('user_id', $userId)
            ->where('priority', 'High')
            ->get();
        $urgentTasks = Task::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<=', now()->addDays(3))
            ->get();
        return view('dashboard', compact('tasks', 'priorityTasks', 'urgentTasks'));
    }
}
