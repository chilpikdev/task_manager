<?php

namespace App\Actions\Tasks\Employee;

use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Actions\Traits\ResponseTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AcceptAction
{
    use GenereateKeyCacheTrait, ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $task = Task::userTasks(auth()->id())->findOrFail($id);

            if ($task->status === StatusEnum::NEW) {
                $task->status = StatusEnum::IN_PROGRESS;
                $task->save();
            } else {
                throw new Exception();
            }

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "task accepted",
            );
        } catch (Exception $ex) {
            throw new ApiErrorException(400, "this item already accepted");
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "item not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
