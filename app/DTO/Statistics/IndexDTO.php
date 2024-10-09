<?php

namespace App\DTO\Statistics;

use App\Http\Requests\Statistics\IndexRequest;

readonly class IndexDTO
{
    public function __construct(
        public ?int $year,
        public ?int $month,
        public ?array $employeesIds,
        public ?int $perPage,
        public ?int $page,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            year: $request->get('year'),
            month: $request->get('month'),
            employeesIds: $request->get('employees_ids'),
            perPage: $request->get('perpage') ?: 10,
            page: $request->get('page') ?: 1,
        );
    }
}
