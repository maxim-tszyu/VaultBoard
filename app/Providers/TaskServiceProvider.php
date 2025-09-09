<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('tasks.*', function ($view) {
            $view->with('sidebarLinks', [
                [
                    'title' => 'All tasks',
                    'url' => route('tasks.index'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Active tasks',
                    'url' => route('tasks.index'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Calendar',
                    'url' => route('tasks.create'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Tasks for today',
                    'url' => route('tasks.create'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Categories',
                    'url' => route('tasks.create'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Important tasks',
                    'url' => route('tasks.create'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
                [
                    'title' => 'Create a new task',
                    'url' => route('tasks.create'),
                    'icon' => 'https://cdn-icons-png.flaticon.com/512/10103/10103630.png ',
                ],
            ]);
        });
    }
}
