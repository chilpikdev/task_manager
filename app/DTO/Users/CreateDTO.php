<?php

namespace App\DTO\Users;

use App\Http\Requests\Users\CreateRequest;

readonly class CreateDTO
{
    public function __construct(
        public string $name,
        public string $position,
        public int $roleId,
        public string $birthday,
        public string $phone,
        public string $password,
        public bool $active,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            name: $request->get('name'),
            position: $request->get('position'),
            roleId: $request->get('role_id'),
            birthday: $request->get('birthday'),
            phone: $request->get('phone'),
            password: $request->get('password'),
            active: $request->get('active'),
        );
    }
}
