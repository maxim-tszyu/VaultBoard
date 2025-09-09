<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:Active,Inactive,Aborted,Completed',
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->back();
    }
}
