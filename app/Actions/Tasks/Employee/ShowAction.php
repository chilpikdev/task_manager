<?php

namespace App\Actions\Tasks\Employee;

use App\Exceptions\ApiErrorException;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Http\Resources\Tasks\Employee\ShowResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ShowAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(int $id): ShowResource
    {
        try {
            $item = Cache::remember("employee:tasks:show:" . $this->generateKey(), now()->addDay(), function () use ($id) {
                $query = Task::select([
                    '*',
                    DB::raw("COALESCE(extended_deadline, deadline) AS actual_deadline")
                ]);

                $query->whereHas('users', function ($subQuery) {
                    $subQuery->where('user_id', auth()->id());
                });

                return $query->findOrFail($id);
            });

            return new ShowResource($item);
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(400, "item not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
