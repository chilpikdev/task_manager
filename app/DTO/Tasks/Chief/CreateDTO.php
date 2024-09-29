<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\CreateRequest;

readonly class CreateDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public string $priority,
        public string $deadline,
        public array $employeesIds,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            title: $request->get('title'),
            description: $request->get('description'),
            priority: $request->get('priority'),
            deadline: $request->get('deadline'),
            employeesIds: $request->get('employees_ids'),
        );
    }
}
