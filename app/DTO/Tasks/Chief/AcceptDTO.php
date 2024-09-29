<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\AcceptRequest;

readonly class AcceptDTO
{
    public function __construct(
        public int $taskId,
        public ?int $point,
        public ?string $text,
    ) {
    }

    public static function from(AcceptRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            point: $request->get('point'),
            text: $request->get('text'),
        );
    }
}
