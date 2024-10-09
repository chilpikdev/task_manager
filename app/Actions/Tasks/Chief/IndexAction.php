<?php

namespace App\Actions\Tasks\Chief;

use App\Exceptions\ApiErrorException;
use App\Http\Resources\Tasks\Chief\IndexCollection;
use App\Models\Task;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\DTO\Tasks\Chief\IndexDTO;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            // $items = Cache::remember("chief_tasks" . $this->generateKey(), now()->addDay(), function () use ($dto) {
            $tasks = Task::where('created_by', auth()->id());

            if ($dto->search) {
                $tasks->where('title', 'like', '%' . $dto->search . '%');
            }

            if ($dto->employeesIds) {
                $tasks->whereHas('users', function ($query) use ($dto) {
                    $query->whereIn('user_id', $dto->employeesIds);
                });
            }

            switch ($dto->state) {
                case 'pending':
                    $tasks
                        ->whereIn('status', ['pending', 'extend'])
                        ->orderByRaw("
                                CASE
                                    WHEN status = 'pending' THEN 1
                                    WHEN status = 'extend' THEN 2
                                    ELSE 3
                                END
                            ")
                        ->orderBy('actual_deadline', 'asc');
                    break;
                case 'active':
                    $tasks
                        ->whereIn('status', ['new', 'in_progress', 'pending', 'correction'])
                        ->whereRaw('COALESCE(extended_deadline, deadline) >= NOW()')
                        ->orderByRaw("
                                CASE
                                    WHEN status = 'new' THEN 1
                                    WHEN status = 'pending' THEN 2
                                    WHEN status = 'correction' THEN 3
                                    ELSE 4
                                END
                            ")
                        ->orderBy('actual_deadline', 'asc');
                    break;
                case 'expired':
                    $tasks
                        ->whereIn('status', ['new', 'in_progress', 'extend', 'pending', 'correction'])
                        ->whereRaw('COALESCE(extended_deadline, deadline) <= NOW()')
                        ->orderByRaw("
                                CASE
                                    WHEN status = 'extend' THEN 1
                                    WHEN status = 'new' THEN 2
                                    ELSE 3
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

            $items = $tasks->paginate(perPage: $dto->perPage, page: $dto->page);
            // });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
