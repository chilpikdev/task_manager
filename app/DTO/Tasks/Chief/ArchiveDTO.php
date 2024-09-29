<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\ArchiveRequest;

readonly class ArchiveDTO
{
    public function __construct(
        public int $taskId,
    ) {
    }

    public static function from(ArchiveRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
        );
    }
}
