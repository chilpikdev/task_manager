<?php

namespace App\Http\Controllers\Tasks;

use App\Actions\Tasks\Employee\AcceptAction;
use App\Actions\Tasks\Employee\CloseAction;
use App\Actions\Tasks\Employee\ExtendAction;
use App\Actions\Tasks\Employee\IndexAction;
use App\DTO\Tasks\Employee\AcceptDTO;
use App\DTO\Tasks\Employee\CloseDTO;
use App\DTO\Tasks\Employee\ExtendDTO;
use App\DTO\Tasks\Employee\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\Employee\AcceptRequest;
use App\Http\Requests\Tasks\Employee\CloseRequest;
use App\Http\Requests\Tasks\Employee\ExtendRequest;
use App\Http\Requests\Tasks\Employee\IndexRequest;
use App\Http\Resources\Tasks\Employee\IndexCollection;
use Illuminate\Http\JsonResponse;

class EmployeeTaskController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Tasks\Employee\IndexRequest $request
     * @param \App\Actions\Tasks\Employee\IndexAction $action
     * @return \App\Http\Resources\Tasks\Employee\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }

    /**
     * Summary of accept
     * @param int $id
     * @param \App\Actions\Tasks\Employee\AcceptAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(AcceptRequest $request, AcceptAction $action): JsonResponse
    {
        return $action(AcceptDTO::from($request));
    }

    /**
     * Summary of close
     * @param \App\Http\Requests\Tasks\Employee\CloseRequest $request
     * @param \App\Actions\Tasks\Employee\CloseAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function close(CloseRequest $request, CloseAction $action): JsonResponse
    {
        return $action(CloseDTO::from($request));
    }

    /**
     * Summary of extend
     * @param \App\Http\Requests\Tasks\Employee\ExtendRequest $request
     * @param \App\Actions\Tasks\Employee\ExtendAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function extend(ExtendRequest $request, ExtendAction $action): JsonResponse
    {
        return $action(ExtendDTO::from($request));
    }
}
