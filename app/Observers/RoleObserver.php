<?php

namespace App\Observers;

use App\Observers\Traits\CacheClearTrait;
use Spatie\Permission\Models\Role;

class RoleObserver
{
    use CacheClearTrait;

    public function created(Role $role): void
    {
        $this->clear('filter_roles');
    }

    public function updated(Role $role): void
    {
        $this->clear('filter_roles');
    }

    public function deleted(Role $role): void
    {
        $this->clear('filter_roles');
    }
}
