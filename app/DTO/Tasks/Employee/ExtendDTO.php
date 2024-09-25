<?php

namespace App\DTO\Tasks\Employee;

use App\Http\Requests\Tasks\Employee\ExtendRequest;

readonly class ExtendDTO
{
    public function __construct(
        public int $taskId,
        public string $dateTime,
    ) {
    }

    public static function from(ExtendRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            dateTime: $request->get('date_time'),
        );
    }
}
