<?php

namespace App\Http\Controllers\Filters;

use App\Actions\Filters\EmployeesAction;
use App\Actions\Filters\RolesAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FiltersController extends Controller
{
    /**
     * Summary of employees
     * @param \App\Actions\Filters\EmployeesAction $action
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function employees(EmployeesAction $action): AnonymousResourceCollection
    {
        return $action();
    }

    /**
     * Summary of roles
     * @param \App\Actions\Filters\RolesAction $action
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function roles(RolesAction $action): AnonymousResourceCollection
    {
        return $action();
    }
}
