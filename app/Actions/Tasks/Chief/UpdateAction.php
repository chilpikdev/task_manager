<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\UpdateDTO;
use App\Enums\StatusEnum;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UpdateAction
{
    use ResponseTrait;

    public function __invoke(UpdateDTO $dto): JsonResponse
    {
        try {
            $task = Task::where('created_by', auth()->id())->findOrFail($dto->taskId);

            if ($task->status != StatusEnum::NEW && $task->status != StatusEnum::IN_PROGRESS && $task->status != StatusEnum::CORRECTION) {
                throw new Exception("You can't update this task, because it's not activity");
            }

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
        } catch (Exception $ex) {
            throw new ApiErrorException(400, $ex->getMessage());
        }  catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "Task not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
