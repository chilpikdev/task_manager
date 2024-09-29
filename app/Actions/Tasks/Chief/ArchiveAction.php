<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\ArchiveDTO;
use App\Enums\StatusEnum;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ArchiveAction
{
    use ResponseTrait;

    public function __invoke(ArchiveDTO $dto): JsonResponse
    {
        try {
            $task = Task::where('created_by', auth()->id())->findOrFail($dto->taskId);

            if ($task->status === StatusEnum::CANCELED) {
                throw new Exception("Task already archived");
            }

            $task->update([
                'archived' => true,
                'status' => StatusEnum::CANCELED,
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Task Archived"
            );
        } catch (Exception $ex) {
            throw new ApiErrorException(400, $ex->getMessage());
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "Task not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
