<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ) {}

    public function index()
    {
        return $this->taskRepository->findAll();
    }
}

