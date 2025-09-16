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
        $tasks = Task::where('user_id', $request->user()->id)->get();
        $priorityTasks = Task::where('user_id', $request->user()->id)->get();;
        $urgentTasks = Task::where('user_id', $request->user()->id)->get();
        return view('dashboard',compact('tasks','priorityTasks','urgentTasks'));
    }
}
