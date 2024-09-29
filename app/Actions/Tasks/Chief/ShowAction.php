<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\ResponseTrait;
use App\Http\Resources\Tasks\Chief\ShowResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowAction
{
    use ResponseTrait;

    public function __invoke(int $id): ShowResource
    {
        try {
            $task = Task::findOrFail($id);
            return new ShowResource($task);
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "Task not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
