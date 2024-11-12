<?php

namespace App\Actions\Users;

use App\Exceptions\ApiErrorException;
use App\Actions\Traits\ResponseTrait;
use App\Helpers\DeleteFilesHelper;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class DeleteAction
{
    use ResponseTrait;

    public function __invoke(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            if (auth()->id() == $id) {
                throw new Exception("Вы не сможете удалить себя!");
            }

            $user->tasks->map(function ($task) use ($id) {
                $task->comments()->where('created_by', $id)->get()->map(function ($comment) {
                    if ($comment->file) {
                        DeleteFilesHelper::file($comment->file->path);
                    }

                    $comment->delete();
                });

                // tasktin' basqa userleri joqpa?
                if ($task->users()->whereNot('id', $id)->count() === 0) {
                    $task->forceDelete();
                }
            });

            $user->tasks()->detach();
            $user->roles()->detach();
            $user->points()->delete();
            $user->forceDelete();

            return $this->toResponse(
                code: 200,
                headers: [],
                message: "Пользователь удалён"
            );
        } catch (Exception $ex) {
            throw new ApiErrorException(400, $ex->getMessage());
        } catch (ModelNotFoundException $th) {
            throw new ApiErrorException(404, "User not found");
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
