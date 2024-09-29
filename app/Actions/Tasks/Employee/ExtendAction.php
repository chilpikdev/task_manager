<?php

namespace App\Actions\Tasks\Employee;

use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Employee\ExtendDTO;
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
            $task = Task::userTasks(auth()->id())->findOrFail($dto->taskId);

            if ($task->status !== StatusEnum::IN_PROGRESS) {
                throw new Exception("Task status not in progress");
            }

            if ($task->actual_deadline >= now()) {
                throw new Exception("Deadline not expired");
            }

            // creating new item for recording requested date time
            $task->taskDeadlineExtends()->create([
                'extend_deadline' => $dto->dateTime,
            ]);

            // updating this task status to extend
            $task->update([
                'status' => StatusEnum::EXTEND
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Запрос на продление успешно отправлен.",
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
