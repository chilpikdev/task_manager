<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'chief_id',
        'employee_id',
        'title',
        'description',
        'deadline',
        'archived',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'archived' => 'bool',
            'priority' => PriorityEnum::class,
            'status' => StatusEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Summary of chief
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chief(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chief_id', 'id');
    }

    /**
     * Summary of employee
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'chief_id', 'id');
    }
}
