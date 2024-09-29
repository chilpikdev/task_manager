<?php

namespace App\Http\Controllers\Tasks;

use App\Actions\Tasks\Chief\CreateAction;
use App\Actions\Tasks\Employee\AcceptAction;
use App\Actions\Tasks\Employee\CloseAction;
use App\Actions\Tasks\Employee\ExtendAction;
use App\Actions\Tasks\Chief\IndexAction;
use App\Actions\Tasks\Chief\ShowAction;
use App\Actions\Tasks\Chief\UpdateAction;
use App\DTO\Tasks\Chief\CreateDTO;
use App\DTO\Tasks\Employee\AcceptDTO;
use App\DTO\Tasks\Employee\CloseDTO;
use App\DTO\Tasks\Employee\ExtendDTO;
use App\DTO\Tasks\Chief\IndexDTO;
use App\DTO\Tasks\Chief\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\Chief\CreateRequest;
use App\Http\Requests\Tasks\Employee\AcceptRequest;
use App\Http\Requests\Tasks\Employee\CloseRequest;
use App\Http\Requests\Tasks\Employee\ExtendRequest;
use App\Http\Requests\Tasks\Chief\IndexRequest;
use App\Http\Requests\Tasks\Chief\UpdateRequest;
use App\Http\Resources\Tasks\Chief\IndexCollection;
use App\Http\Resources\Tasks\Chief\ShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChiefTaskController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Tasks\Chief\IndexRequest $request
     * @param \App\Actions\Tasks\Chief\IndexAction $action
     * @return \App\Http\Resources\Tasks\Chief\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\Tasks\Chief\CreateRequest $request
     * @param \App\Actions\Tasks\Chief\CreateAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDTO::from($request));
    }

    /**
     * Summary of show
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\Tasks\Chief\ShowAction $action
     * @return \App\Http\Resources\Tasks\Chief\ShowResource
     */
    public function show(Request $request, ShowAction $action): ShowResource
    {
        return $action($request->id);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Tasks\Chief\UpdateRequest $request
     * @param \App\Actions\Tasks\Chief\UpdateAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action(UpdateDTO::from($request));
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
