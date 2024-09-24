<?php

namespace App\DTO\Comments;

use App\Http\Requests\Comments\IndexRequest;

readonly class IndexDTO
{
    public function __construct(
        public int $taskId,
        public ?int $perPage,
        public ?int $page,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            perPage: $request->get('perpage') ?: 10,
            page: $request->get('page') ?: 1,
        );
    }
}
