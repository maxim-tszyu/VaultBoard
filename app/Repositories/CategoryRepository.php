<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository
{
    public static function findAllBelongingToUser(): Collection
    {
        return Category::where('user_id', auth()->id())->get();
    }
}
