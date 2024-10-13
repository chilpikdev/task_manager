<?php

namespace App\Actions\Statistics;

use App\DTO\Statistics\IndexDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Statistics\IndexCollection;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            // $items = Cache::remember("statistics" . $this->generateKey(), now()->addDay(), function () use ($dto) {
            $users = User::role('employee')->where('id', '<>', auth()->id());

            $subQueryYear = "";
            $subQueryMonth = "";

            if ($dto->year) {
                $subQueryYear = "
                    AND EXTRACT(YEAR FROM table.created_at) = $dto->year
                ";
            }

            if ($dto->month) {
                $subQueryMonth = "
                    AND EXTRACT(MONTH FROM table.created_at) = $dto->month
                ";
            }

            $users->select([
                '*',
                // баллы
                DB::raw("
                        (
                            SELECT
                                COALESCE(SUM(point), 0)
                            FROM
                                user_points
                            WHERE
                                users.id = user_points.employee_id
                                " . str_replace('table', 'user_points', $subQueryYear) . "
                                " . str_replace('table', 'user_points', $subQueryMonth) . "
                        ) as points
                    "),
                // выполненные задачи
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status = 'completed'
                            AND tasks.extended_deadline IS NULL
                            AND tasks.priority = 'high'
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as completed_on_time_high
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status = 'completed'
                            AND tasks.extended_deadline IS NULL
                            AND tasks.priority = 'medium'
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as completed_on_time_medium
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status = 'completed'
                            AND tasks.extended_deadline IS NOT NULL
                            AND tasks.priority = 'high'
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as completed_expired_high
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status = 'completed'
                            AND tasks.extended_deadline IS NOT NULL
                            AND tasks.priority = 'medium'
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as completed_expired_medium
                "),
                // не выполненные задачи
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status IN ('new', 'in_progress', 'pending', 'correction')
                            AND tasks.priority = 'high'
                            AND COALESCE(extended_deadline, deadline) >= NOW()
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as unfulfilled_active_high
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status IN ('new', 'in_progress', 'pending', 'correction')
                            AND tasks.priority = 'medium'
                            AND COALESCE(extended_deadline, deadline) >= NOW()
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as unfulfilled_active_medium
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status IN ('new', 'in_progress', 'pending', 'extend', 'correction')
                            AND tasks.priority = 'high'
                            AND COALESCE(extended_deadline, deadline) <= NOW()
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as unfulfilled_expired_high
                "),
                DB::raw("
                    (
                        SELECT
                            COUNT(tasks.*)
                        FROM
                            tasks
                        JOIN task_user ON task_user.task_id = tasks.id
                        WHERE
                            users.id = task_user.user_id
                            AND tasks.status IN ('new', 'in_progress', 'pending', 'extend', 'correction')
                            AND tasks.priority = 'medium'
                            AND COALESCE(extended_deadline, deadline) <= NOW()
                            " . str_replace('table', 'tasks', $subQueryYear) . "
                            " . str_replace('table', 'tasks', $subQueryMonth) . "
                    ) as unfulfilled_expired_medium
                "),
            ]);

            if ($dto->employeesIds) {
                $users->whereIn('id', $dto->employeesIds);
            }

            $users->orderByDesc('points');

            $items = $users->paginate(perPage: $dto->perPage, page: $dto->page);
            // });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
