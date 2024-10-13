<?php

namespace App\Observers;

use App\Models\User;
use App\Observers\Traits\CacheClearTrait;

class UserObserver
{
    use CacheClearTrait;

    public function created(User $user): void
    {
        $this->clear('users');
        $this->clear('filter_employees');
        // $this->clear('statistics');
    }

    public function updated(User $user): void
    {
        $this->clear('users');
        $this->clear('filter_employees');
        // $this->clear('statistics');
    }

    public function deleted(User $user): void
    {
        $this->clear('users');
        $this->clear('filter_employees');
        // $this->clear('statistics');
    }
}
