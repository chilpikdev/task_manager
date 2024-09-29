<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPoint extends Model
{
    use HasFactory;

    protected $table = 'user_points';

    protected $fillable = [
        'employee_id',
        'task_id',
        'point',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of employee
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee(): HasOne
    {
        return $this->hasOne(User::class, 'employee_id', 'id');
    }

    /**
     * Summary of task
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function task(): HasOne
    {
        return $this->hasOne(Task::class, 'task_id', 'id');
    }
}
