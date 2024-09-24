<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Task;
use App\Observers\CommentObserver;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
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
        Task::observe(TaskObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
