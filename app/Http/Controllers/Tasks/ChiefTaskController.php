<?php

namespace App\Http\Controllers\Tasks;

use App\Actions\Tasks\Chief\ArchiveAction;
use App\Actions\Tasks\Chief\CreateAction;
use App\Actions\Tasks\Chief\AcceptAction;
use App\Actions\Tasks\Chief\CorrectionAction;
use App\Actions\Tasks\Chief\ExtendAction;
use App\Actions\Tasks\Chief\IndexAction;
use App\Actions\Tasks\Chief\ShowAction;
use App\Actions\Tasks\Chief\UpdateAction;
use App\DTO\Tasks\Chief\ArchiveDTO;
use App\DTO\Tasks\Chief\CreateDTO;
use App\DTO\Tasks\Chief\AcceptDTO;
use App\DTO\Tasks\Chief\CorrectionDTO;
use App\DTO\Tasks\Chief\ExtendDTO;
use App\DTO\Tasks\Chief\IndexDTO;
use App\DTO\Tasks\Chief\UpdateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\Chief\ArchiveRequest;
use App\Http\Requests\Tasks\Chief\CreateRequest;
use App\Http\Requests\Tasks\Chief\AcceptRequest;
use App\Http\Requests\Tasks\Chief\CorrectionRequest;
use App\Http\Requests\Tasks\Chief\ExtendRequest;
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
     * Summary of toArchive
     * @param \App\Http\Requests\Tasks\Chief\ArchiveRequest $request
     * @param \App\Actions\Tasks\Chief\ArchiveAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function toArchive(ArchiveRequest $request, ArchiveAction $action): JsonResponse
    {
        return $action(ArchiveDTO::from($request));
    }

    /**
     * Summary of accept
     * @param \App\Http\Requests\Tasks\Chief\AcceptRequest $request
     * @param \App\Actions\Tasks\Chief\AcceptAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function accept(AcceptRequest $request, AcceptAction $action): JsonResponse
    {
        return $action(AcceptDTO::from($request));
    }

    /**
     * Summary of extend
     * @param \App\Http\Requests\Tasks\Chief\ExtendRequest $request
     * @param \App\Actions\Tasks\Chief\ExtendAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function extend(ExtendRequest $request, ExtendAction $action): JsonResponse
    {
        return $action(ExtendDTO::from($request));
    }

    /**
     * Summary of correction
     * @param \App\Http\Requests\Tasks\Chief\CorrectionRequest $request
     * @param \App\Actions\Tasks\Chief\CorrectionAction $action
     * @return \Illuminate\Http\JsonResponse
     */
    public function correction(CorrectionRequest $request, CorrectionAction $action): JsonResponse
    {
        return $action(CorrectionDTO::from($request));
    }
}
