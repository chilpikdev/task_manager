<?php

namespace App\Actions\Tasks\Employee;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Http\Resources\Tasks\Employee\ShowResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;

class ShowAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(int $id): ShowResource
    {
        try {
            $item = Cache::remember("employee:tasks:show:" . $this->generateKey(), now()->addDay(), function () use ($id) {
                $query = Task::userTasks(auth()->id());

                return $query->findOrFail($id);
            });

            return new ShowResource($item);
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "item not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
