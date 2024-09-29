<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\UpdateDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(UpdateDTO $dto): JsonResponse
    {
        try {
            $task = Task::findOrFail($dto->taskId);

            $data = [
                'title' => $dto->title,
                'description' => $dto->description,
                'priority' => $dto->priority,
            ];

            if ($dto->newDeadline) {
                $data['extended_deadline'] = $dto->newDeadline;
            }

            $task->update($data);

            if ($dto->employeesIds) {
                $task->users()->sync($dto->employeesIds);
            }

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Task Updated"
            );
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "Task not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
