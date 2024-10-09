<?php

namespace App\Actions\Statistics;

use App\DTO\Statistics\IndexDTO;
use App\Exceptions\ApiErrorException;
use App\Http\Resources\Statistics\IndexCollection;
use App\Actions\Traits\GenereateKeyCacheTrait;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    use GenereateKeyCacheTrait;

    public function __invoke(IndexDTO $dto): IndexCollection
    {
        try {
            $items = Cache::remember("statistics" . $this->generateKey(), now()->addDay(), function () use ($dto) {
                $users = User::query();


                $users->orderBy('id');

                return $users->paginate(perPage: $dto->perPage, page: $dto->page);
            });

            return new IndexCollection($items);
        } catch (\Throwable $th) {
            throw new ApiErrorException(500, $th->getMessage());
        }
    }
}
