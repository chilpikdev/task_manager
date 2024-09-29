<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\UpdateRequest;

readonly class UpdateDTO
{
    public function __construct(
        public int $taskId,
        public string $title,
        public string $description,
        public string $priority,
        public ?string $newDeadline,
        public ?array $employeesIds,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            title: $request->get('title'),
            description: $request->get('description'),
            priority: $request->get('priority'),
            newDeadline: $request->get('new_deadline'),
            employeesIds: $request->get('employees_ids'),
        );
    }
}
