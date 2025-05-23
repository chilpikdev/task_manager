<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\ExtendRequest;

readonly class ExtendDTO
{
    public function __construct(
        public int $taskId,
    ) {
    }

    public static function from(ExtendRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
        );
    }
}
