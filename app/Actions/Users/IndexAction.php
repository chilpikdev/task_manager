<?php

namespace App\Actions\Users;

use App\DTO\Users\IndexDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Users\IndexCollection;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            $items = Cache::remember("users" . $this->generateKey(), now()->addDay(), function () use ($dto) {
                $users = User::query();

                if ($dto->search) {
                    $users
                        ->whereLike("name", "%" . $dto->search . "%")
                        ->orWhereLike("position", "%" . $dto->search . "%")
                        ->orWhereLike("phone", "%" . $dto->search . "%");
                }

                $users->orderBy('id');

                return $users->paginate(perPage: $dto->perPage, page: $dto->page);
            });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
