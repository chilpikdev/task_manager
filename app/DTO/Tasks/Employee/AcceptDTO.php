<?php

namespace App\DTO\Tasks\Employee;

use App\Http\Requests\Tasks\Employee\AcceptRequest;

readonly class AcceptDTO
{
    public function __construct(
        public int $taskId,
    ) {
    }

    public static function from(AcceptRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
        );
    }
}
