<?php

namespace App\Observers;

use App\Models\Comment;
use App\Observers\Traits\CacheClearTrait;

class CommentObserver
{
    use CacheClearTrait;

    public function created(Comment $comment): void
    {
        $this->clear('comments');
    }

    public function updated(Comment $comment): void
    {
        $this->clear('comments');
    }

    public function deleted(Comment $comment): void
    {
        $this->clear('tasks');
    }
}
