<?php

namespace App\DTO\Tasks\Chief;

use App\Http\Requests\Tasks\Chief\CorrectionRequest;

readonly class CorrectionDTO
{
    public function __construct(
        public int $taskId,
        public string $text,
    ) {
    }

    public static function from(CorrectionRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            text: $request->get('text'),
        );
    }
}
