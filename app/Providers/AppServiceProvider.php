<?php

namespace App\Providers;

use App\Contracts\EmbeddableContract;
use App\Models\ActivityLog;
use App\Models\Task;
use App\Observers\ActivityLogObserver;
use App\Observers\EmbeddableObserver;
use App\Observers\TaskObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Task::observe(TaskObserver::class);
        ActivityLog::observe(ActivityLogObserver::class);

        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, EmbeddableContract::class) && in_array(
                    EmbeddableContract::class,
                    class_implements($class),
                    true
                )) {
                $class::observe(EmbeddableObserver::class);
            }
        }
    }
}
