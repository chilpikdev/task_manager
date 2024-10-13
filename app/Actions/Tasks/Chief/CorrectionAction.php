<?php

namespace App\Actions\Tasks\Chief;

use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\CorrectionDTO;
use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Models\Comment;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class CorrectionAction
{
    use ResponseTrait;

    public function __invoke(CorrectionDTO $dto): JsonResponse
    {
        try {
            $task = Task::where('created_by', auth()->id())->findOrFail($dto->taskId);

            if ($task->status !== StatusEnum::PENDING) {
                throw new Exception("Task not pending");
            }

            Comment::create([
                'task_id' => $task->id,
                'created_by' => auth()->id(),
                'text' => $dto->text
            ]);

            $task->update([
                'status' => StatusEnum::CORRECTION
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Задача отправлена для исрпавления.",
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
