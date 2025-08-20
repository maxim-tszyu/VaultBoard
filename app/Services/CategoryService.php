<?php

namespace App\Services;

use App\DTO\CategoryCreateDTO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function index()
    {
        return $this->categoryRepository->findAllBelongingToUser();
    }

    public function store(CategoryCreateDTO $categoryCreateDTO)
    {
        Category::create([
            'user_id' => Auth::user()->id,
            'title' => $categoryCreateDTO->title
        ]);
    }
}
