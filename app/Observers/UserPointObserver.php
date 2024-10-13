<?php

namespace App\Observers;

use App\Observers\Traits\CacheClearTrait;
use Spatie\Permission\Models\Role;

class UserPointObserver
{
    use CacheClearTrait;

    public function created(Role $role): void
    {
        $this->clear('statistics');
    }

    public function updated(Role $role): void
    {
        $this->clear('statistics');
    }

    public function deleted(Role $role): void
    {
        $this->clear('statistics');
    }
}
