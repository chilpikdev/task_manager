<?php

namespace App\DTO\Tasks;

use App\Http\Requests\Tasks\IndexRequest;

readonly class IndexDTO
{
    public function __construct(
        public ?string $search,
        public string $state,
        public ?int $perPage,
        public ?int $page,
        public ?string $year,
        public ?string $month,
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
        );
    }
}
