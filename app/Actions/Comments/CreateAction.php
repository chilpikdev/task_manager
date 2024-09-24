<?php

namespace App\Actions\Comments;

use App\Actions\Traits\ResponseTrait;
use App\DTO\Comments\CreateDTO;
use App\Enums\StatusEnum;
use App\Exceptions\ApiErrorException;
use App\Helpers\UploadFilesHelper;
use App\Models\Comment;
use App\Models\Task;
use Exception;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreateAction
{
    use ResponseTrait;

    public function __invoke(CreateDTO $dto): JsonResponse
    {
        try {
            $task = Task::find($dto->taskId);

            if (!$task) {
                throw new NotFoundHttpException("Task not found");
            }

            if ($task->status !== StatusEnum::IN_PROGRESS) {
                throw new HttpClientException("Task Pending");
            }

            if ($task->actual_deadline < now()) {
                throw new HttpClientException("Deadline expired");
            }

            $data = [
                'task_id' => $dto->taskId,
                'created_by' => auth()->id(),
                'text' => $dto->text,
            ];

            if ($dto->file) {
                $data['file'] = [
                    'path' => UploadFilesHelper::file($dto->file, 'attachments', $task->id),
                    'type' => $dto->file->extension()
                ];
            }

            Comment::create($data);

            // after creating we changed task status to pending
            $task->status = StatusEnum::PENDING;
            $task->save();

            return $this->toResponse(
                code: 200,
                headers: [],
                message: 'Comment was created',
            );
        } catch (HttpClientException $th) {
            throw new ApiErrorException(400, $th->getMessage());
        } catch (NotFoundHttpException $th) {
            throw new ApiErrorException(404, $th->getMessage());
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
