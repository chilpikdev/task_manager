<?php

namespace App\DTO\Tasks\Employee;

use App\Http\Requests\Tasks\Employee\CloseRequest;

readonly class CloseDTO
{
    public function __construct(
        public int $taskId,
        public string $text,
        public ?object $file,
    ) {
    }

    public static function from(CloseRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            text: $request->get('text'),
            file: $request->file('file'),
        );
    }
}
