<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

class NoteRepository
{
    public static function findAllBelongingToUser(): Collection
    {
        return Note::where('user_id', auth()->id())->get();
    }
}
