<?php

namespace App\Http\Controllers;

use App\DTO\TaskCreateDTO;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Jobs\GenerateAiReport;
use App\Models\Category;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private TaskService $taskService)
    {
    }

    public function index()
    {
        $data = $this->taskService->index();

        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $dto = TaskCreateDTO::fromRequest($request);
        $this->taskService->store($dto);

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $cacheKey = "ai_report_task_{$task->id}";
        $report = Cache::get($cacheKey);

        $params = ['task' => $task];
        $shouldRegenerate = false;

        if (is_string($report)) {
            if ($report === 'pending') {
                $params['ai_report'] = null;
            } elseif ($report === 'failed') {
                $lastFailedAt = Cache::get("ai_report_failed_at_{$task->id}");
                if (!$lastFailedAt || now()->diffInMinutes($lastFailedAt) > 10) {
                    $shouldRegenerate = true;
                }
                $params['ai_report'] = null;
            } else {
                $params['ai_report'] = $report;
            }
        } else {
            $params['ai_report'] = null;
            $shouldRegenerate = true;
        }

        if ($shouldRegenerate) {
            Cache::put($cacheKey, 'pending', now()->addHour());
            Cache::put("ai_report_failed_at_{$task->id}", now(), now()->addHour());
            dispatch(new GenerateAiReport($task->id));
        }

        return view('tasks.show', $params);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $categories = Category::all();
        $allTasks = Task::where('user_id', '=', auth()->user()->id)->get();
        return view('tasks.edit', compact('task', 'categories', 'allTasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return redirect()->route('tasks.show', $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
