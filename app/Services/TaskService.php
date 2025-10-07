<?php

namespace App\Services;

use App\DTO\TaskCreateDTO;
use App\Enums\Status;
use App\Models\Task;
use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function index()
    {
        $tasks = $this->taskRepository->findAllTasksBelongingToUser();
        $priorityTasks = $this->taskRepository->findAllPriorityTasksBelongingToUser();
        $urgentTasks = $this->taskRepository->findAllUrgentTasksBelongingToUser();

        return compact('tasks', 'priorityTasks', 'urgentTasks');
    }

    public function store(TaskCreateDTO $taskCreateDTO)
    {
        $task = Task::create([
            'title' => $taskCreateDTO->title,
            'description' => $taskCreateDTO->description,
            'user_id' => auth()->id(),
            'parent_task_id' => $taskCreateDTO->parent_task_id,
            'due_date' => $taskCreateDTO->due_date,
            'priority' => $taskCreateDTO->priority->value,
            'status' => Status::INACTIVE,
        ]);
        if (! empty($taskCreateDTO->category_ids)) {
            $task->categories()->sync($taskCreateDTO->category_ids);
        }

        return $task;
    }
}
