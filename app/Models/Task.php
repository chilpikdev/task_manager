<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'created_by',
        'title',
        'description',
        'deadline',
        'extended_deadline',
        'archived',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'extended_deadline' => 'datetime',
            'archived' => 'bool',
            'priority' => PriorityEnum::class,
            'status' => StatusEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('actual_deadline', function (Builder $builder) {
            $builder
                ->select('*')
                ->selectSub('COALESCE(extended_deadline, deadline)', 'actual_deadline');
        });
    }

    public function scopeUserTasks(Builder $builder, int $userId): Builder
    {
        return $builder->whereHas('users', function ($subQuery) use ($userId) {
            $subQuery->where('user_id', $userId);
        });
    }

    /**
     * Summary of Created By
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Summary of users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }

    /**
     * Summary of extendDeadline
     * @return mixed
     */
    public function extendDeadline(): mixed
    {
        $extendDeadline = $this->hasOne(TaskDeadlineExtend::class, 'task_id', 'id')->orderByDesc('id');

        return $this->status == StatusEnum::EXTEND && $extendDeadline ? $extendDeadline->extend_deadline : null;
    }
}
