<?php

namespace App\Actions\Tasks\Employee;

use App\DTO\Tasks\IndexDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Tasks\Employee\IndexCollection;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            $items = Cache::remember("employee:tasks:" . $this->generateKey(), now()->addDay(), function () use ($dto) {
                $tasks = Task::select([
                    '*',
                    DB::raw("COALESCE(extended_deadline, deadline) AS actual_deadline")
                ]);

                $tasks->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->id());
                });

                if ($dto->search) {
                    $tasks->where('title', 'like', '%' . $dto->search . '%');
                }

                switch ($dto->state) {
                    case 'active':
                        $tasks
                            ->whereIn('status', ['new', 'in_progress'])
                            ->whereRaw('COALESCE(extended_deadline, deadline) >= NOW()')
                            ->orderByRaw("
                                CASE
                                    WHEN status = 'new' THEN 1
                                    ELSE 2
                                END
                            ")
                            ->orderBy('actual_deadline', 'asc');
                        break;
                    case 'expired':
                        $tasks
                            ->whereIn('status', ['new', 'in_progress', 'pending', 'correction'])
                            ->whereRaw('COALESCE(extended_deadline, deadline) < NOW()')
                            ->orderByRaw("
                                CASE
                                    WHEN status = 'new' THEN 1
                                    ELSE 2
                                END
                            ")
                            ->orderBy('actual_deadline', 'asc');
                        break;
                    case 'completed':
                        $tasks
                            ->where('status', '=', 'completed')
                            ->orderByDesc('updated_at');
                        break;
                    case 'archived':
                        $tasks
                            ->where('archived', '=', true)
                            ->orderByDesc('updated_at');
                        break;
                }

                if ($dto->year) {
                    $tasks->whereYear('created_at', '=', $dto->year);
                }

                if ($dto->month) {
                    $tasks->whereMonth('created_at', '=', $dto->month);
                }

                return $tasks->paginate(perPage: $dto->perPage, page: $dto->page);
            });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
