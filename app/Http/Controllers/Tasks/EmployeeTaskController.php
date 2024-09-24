<?php

namespace App\Http\Controllers\Tasks;

use App\Actions\Tasks\Employee\AcceptAction;
use App\Actions\Tasks\Employee\IndexAction;
use App\Actions\Tasks\Employee\ShowAction;
use App\DTO\Tasks\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\IndexRequest;
use App\Http\Resources\Tasks\Employee\IndexCollection;
use App\Http\Resources\Tasks\Employee\ShowResource;
use Illuminate\Http\JsonResponse;

class EmployeeTaskController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Tasks\IndexRequest $request
     * @param \App\Actions\Tasks\Employee\IndexAction $action
     * @return \App\Http\Resources\Tasks\Employee\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }

    /**
     * Summary of show
     * @param int $id
     * @param \App\Actions\Tasks\Employee\ShowAction $action
     * @return \App\Http\Resources\Tasks\Employee\ShowResource
     */
    public function show(int $id, ShowAction $action): ShowResource
    {
        return $action($id);
    }

    /**
     * Summary of accept
     * @param int $id
     * @param \App\Actions\Tasks\Employee\AcceptAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(int $id, AcceptAction $action): JsonResponse
    {
        return $action($id);
    }
}
