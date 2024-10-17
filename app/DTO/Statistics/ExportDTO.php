<?php

namespace App\DTO\Statistics;

use App\Http\Requests\Statistics\ExportRequest;

readonly class ExportDTO
{
    public function __construct(
        public ?int $year,
        public ?int $month,
        public ?array $employeesIds,
    ) {
    }

    public static function from(ExportRequest $request): self
    {
        return new self(
            year: $request->get('year'),
            month: $request->get('month'),
            employeesIds: $request->get('employees_ids'),
        );
    }
}
