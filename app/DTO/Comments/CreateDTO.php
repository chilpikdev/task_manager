<?php

namespace App\DTO\Comments;
use App\Http\Requests\Comments\CreateRequest;

readonly class CreateDTO
{
    public function __construct(
        public int $taskId,
        public string $text,
        public ?object $file,
    ) {
    }

    public static function from(CreateRequest $request): self
    {
        return new self(
            taskId: $request->get('task_id'),
            text: $request->get('text'),
            file: $request->file('file'),
        );
    }
}
