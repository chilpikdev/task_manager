<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\IndexRequest;

readonly class IndexDTO
{
    public function __construct(
        public ?string $search,
        public string $state,
        public ?int $perPage,
        public ?int $page,
        public ?int $year,
        public ?int $month,
        public ?array $employeesIds,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            search: $request->get('search'),
            state: $request->get('state'),
            perPage: $request->get('perpage') ?: 10,
            page: $request->get('page') ?: 1,
            year: $request->get('year'),
            month: $request->get('month'),
            employeesIds: $request->get('employees_ids'),
        );
    }
}
