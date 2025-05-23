<?php

namespace App\Actions\Tasks\Chief;

use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\ExtendDTO;
use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ExtendAction
{
    use ResponseTrait;

    public function __invoke(ExtendDTO $dto): JsonResponse
    {
        try {
            $task = Task::where('created_by', auth()->id())->findOrFail($dto->taskId);

            if ($task->status !== StatusEnum::EXTEND && !$task->extendDeadline()) {
                throw new Exception("Task status not sended for extending");
            }

            $task->update([
                'extended_deadline' => $task->extendDeadline(),
                'status' => StatusEnum::IN_PROGRESS
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Задача успешно продлён.",
            );
        } catch (Exception $th) {
            throw new ApiErrorException(400, $th->getMessage());
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "Task not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
