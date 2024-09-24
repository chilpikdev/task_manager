<?php

namespace App\Actions\Comments;

use App\DTO\Comments\IndexDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Comments\IndexCollection;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            $items = Cache::remember("comments:" . $this->generateKey(), now()->addDay(), function () use ($dto) {
                $comments = Comment::where('task_id', $dto->taskId);

                $comments->orderBy('id');

                return $comments->paginate(perPage: $dto->perPage, page: $dto->page);
            });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
