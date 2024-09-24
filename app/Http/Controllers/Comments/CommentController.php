<?php

namespace App\Http\Controllers\Comments;

use App\Actions\Comments\CreateAction;
use App\Actions\Comments\IndexAction;
use App\DTO\Comments\CreateDTO;
use App\DTO\Comments\IndexDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CreateRequest;
use App\Http\Requests\Comments\IndexRequest;
use App\Http\Resources\Comments\IndexCollection;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Summary of index
     * @param \App\Http\Requests\Comments\IndexRequest $request
     * @param \App\Actions\Comments\IndexAction $action
     * @return \App\Http\Resources\Comments\IndexCollection
     */
    public function index(IndexRequest $request, IndexAction $action): IndexCollection
    {
        return $action(IndexDTO::from($request));
    }

    public function create(CreateRequest $request, CreateAction $action): JsonResponse
    {
        return $action(CreateDTO::from($request));
    }
}
