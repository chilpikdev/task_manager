<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\CreateDTO;
use Illuminate\Http\JsonResponse;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDTO $dto): JsonResponse
    {
        try {
            $data = [
                'created_by' => auth()->id(),
                'title' => $dto->title,
                'description' => $dto->description,
                'priority' => $dto->priority,
                'deadline' => $dto->deadline,
            ];

            $task = Task::create($data);

            $task->users()->attach($dto->employeesIds);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Task Created"
            );
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
