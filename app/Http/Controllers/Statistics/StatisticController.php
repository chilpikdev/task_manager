<?php

namespace App\Http\Controllers\Statistics;

use App\Actions\Statistics\IndexAction;
use App\DTO\Statistics\ExportDTO;
use App\DTO\Statistics\IndexDTO;
use App\Exports\StatisticExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\ExportRequest;
use App\Http\Requests\Statistics\IndexRequest;
use App\Http\Resources\Statistics\IndexCollection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    /**
     * Summary of export
     * @param \App\Http\Requests\Statistics\ExportRequest $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(ExportRequest $request): BinaryFileResponse
    {
        return Excel::download(new StatisticExport(ExportDTO::from($request)), 'statistics_report.xlsx');
    }
}
