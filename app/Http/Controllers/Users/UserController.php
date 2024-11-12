<?php

namespace App\Http\Controllers\Users;

use App\Actions\Users\CreateAction;
use App\Actions\Users\DeleteAction;
use App\Actions\Users\IndexAction;
use App\Actions\Users\ShowAction;
use App\Actions\Users\UpdateAction;
use App\DTO\Users\CreateDTO;
use App\DTO\Users\IndexDTO;
use App\DTO\Users\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\IndexRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Http\Resources\Users\IndexCollection;
use App\Http\Resources\Users\ShowResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Users\IndexRequest $request
     * @param \App\Actions\Users\IndexAction $action
     * @return \App\Http\Resources\Users\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }

    /**
     * Summary of create
     * @param \App\Http\Requests\Users\CreateRequest $request
     * @param \App\Actions\Users\CreateAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDTO::from($request));
    }

    /**
     * Summary of show
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\Users\ShowAction $action
     * @return \App\Http\Resources\Users\ShowResource
     */
    public function show(Request $request, ShowAction $action): ShowResource
    {
        return $action($request->id);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Users\UpdateRequest $request
     * @param \App\Actions\Users\UpdateAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, UpdateAction $action): JsonResponse
    {
        return $action(UpdateDTO::from($request));
    }

    /**
     * Summary of delete
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\Users\DeleteAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, DeleteAction $action): JsonResponse
    {
        return $action($request->id);
    }
}
