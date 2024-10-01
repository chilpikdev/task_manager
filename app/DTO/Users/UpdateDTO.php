<?php

namespace App\DTO\Users;

use App\Http\Requests\Users\UpdateRequest;

readonly class UpdateDTO
{
    public function __construct(
        public int $userId,
        public string $name,
        public string $position,
        public int $roleId,
        public string $birthday,
        public string $phone,
        public ?string $password,
        public bool $active,
    ) {
    }

    public static function from(UpdateRequest $request): self
    {
        return new self(
            userId: $request->get('user_id'),
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
