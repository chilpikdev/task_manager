<?php

namespace App\Observers;

use App\Models\Task;
use App\Observers\Traits\CacheClearTrait;

class TaskObserver
{
    use CacheClearTrait;

    public function created(Task $task): void
    {
        $this->clear('chief_tasks');
        $this->clear('employees_tasks');
    }

    public function updated(Task $task): void
    {
        $this->clear('chief_tasks');
        $this->clear('employees_tasks');
    }

    public function deleted(Task $task): void
    {
        $this->clear('chief_tasks');
        $this->clear('employees_tasks');
    }
}
