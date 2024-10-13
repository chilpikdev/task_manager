<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use App\Models\UserPoint;
use App\Observers\CommentObserver;
use App\Observers\RoleObserver;
use App\Observers\TaskObserver;
use App\Observers\UserObserver;
use App\Observers\UserPointObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

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
        // Task::observe(TaskObserver::class);
        Comment::observe(CommentObserver::class);
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        // UserPoint::observe(UserPointObserver::class);
    }
}
