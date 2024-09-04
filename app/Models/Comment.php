<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'task_id',
        'created_by',
        'comment_id',
        'text',
        'file',
    ];

    protected function casts(): array
    {
        return [
            'file' => 'object',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of task
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    /**
     * Summary of createdBy
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Summary of comment
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function comment(): HasOne
    {
        return $this->hasOne($this, 'comment_id', 'id');
    }
}
