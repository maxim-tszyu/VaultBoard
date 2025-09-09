<?php

namespace App\Services;

use App\DTO\NoteDTO;
use App\Models\Note;
use App\Repositories\NoteRepository;

class NoteService
{
    public function __construct(
        private NoteRepository $noteRepository
    ) {}

    public function index()
    {
        return $this->noteRepository->findAllBelongingToUser();
    }

    public function store(NoteDTO $dto)
    {
        Note::create([
            'task_id' => $dto->task_id,
            'content' => $dto->content,
        ]);
    }
}
