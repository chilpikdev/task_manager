<?php

namespace App\Actions\Tasks\Chief;

use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Actions\Traits\ResponseTrait;
use App\DTO\Tasks\Chief\AcceptDTO;
use App\Models\Comment;
use App\Models\UserPoint;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AcceptAction
{
    use GenereateKeyCacheTrait, ResponseTrait;

    public function __invoke(AcceptDTO $dto): JsonResponse
    {
        try {
            $task = Task::where('created_by', auth()->id())->findOrFail($dto->taskId);

            if ($task->status !== StatusEnum::PENDING) {
                throw new Exception("Task not pending");
            }

            foreach ($task->users as $user) {
                UserPoint::create([
                    'employee_id' => $user->id,
                    'task_id' => $task->id,
                    'point' => $dto->point ?: 0,
                ]);
            }

            if ($dto->text) {
                Comment::create([
                    'task_id' => $task->id,
                    'created_by' => auth()->id(),
                    'text' => $dto->text
                ]);
            }

            $task->update([
                'status' => StatusEnum::COMPLETED
            ]);

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "task accepted",
            );
        } catch (Exception $ex) {
            throw new ApiErrorException(400, $ex->getMessage());
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "item not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
