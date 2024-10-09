<?php

namespace App\Http\Controllers\Statistics;

use App\Actions\Statistics\IndexAction;
use App\DTO\Statistics\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\IndexRequest;
use App\Http\Resources\Statistics\IndexCollection;

class StatisticController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Statistics\IndexRequest $request
     * @param \App\Actions\Statistics\IndexAction $action
     * @return \App\Http\Resources\Statistics\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }
}
