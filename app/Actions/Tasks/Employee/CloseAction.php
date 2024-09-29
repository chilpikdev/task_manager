<?php

namespace App\Actions\Tasks\Employee;

use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Employee\CloseDTO;
use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Helpers\UploadFilesHelper;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CloseAction
{
    use ResponseTrait;

    public function __invoke(CloseDTO $dto): JsonResponse
    {
        try {
            $task = Task::userTasks(auth()->id())->findOrFail($dto->taskId);

            if ($task->status !== StatusEnum::IN_PROGRESS && $task->status !== StatusEnum::CORRECTION) {
                throw new Exception("Task status not in progress");
            }

            if ($task->actual_deadline < now()) {
                throw new Exception("Deadline expired");
            }

            $data = [
                'task_id' => $dto->taskId,
                'created_by' => auth()->id(),
                'text' => $dto->text,
            ];

            if ($dto->file) {
                $data['file'] = [
                    'path' => UploadFilesHelper::file($dto->file, 'attachments', $task->id),
                    'type' => $dto->file->extension()
                ];
            }

            $task->comments()->create($data);

            // after creating we changed task status to pending
            $task->update([
                'status' => StatusEnum::PENDING
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: 'Task closed and sended to examination',
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
