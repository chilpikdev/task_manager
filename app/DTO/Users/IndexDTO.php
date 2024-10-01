<?php

namespace App\DTO\Users;

use App\Http\Requests\Users\IndexRequest;

readonly class IndexDTO
{
    public function __construct(
        public ?string $search,
        public ?int $perPage,
        public ?int $page,
    ) {
    }

    public static function from(IndexRequest $request): self
    {
        return new self(
            search: $request->get('search'),
            perPage: $request->get('perpage') ?: 10,
            page: $request->get('page') ?: 1,
        );
    }
}
