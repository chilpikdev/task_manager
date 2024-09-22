<?php

namespace App\Observers;

use App\Models\Task;
use App\Observers\Traits\CacheClearTrait;

class TasksObserver
{
    use CacheClearTrait;

    public function created(Task $task): void
    {
        $this->clear('tasks');
    }

    public function updated(Task $task): void
    {
        $this->clear('tasks');
    }

    public function deleted(Task $task): void
    {
        $this->clear('tasks');
    }
}
