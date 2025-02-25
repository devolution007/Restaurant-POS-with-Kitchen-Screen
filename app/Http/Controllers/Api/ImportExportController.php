<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ImportCsvFileRequest;
use App\Services\ExportService;
use App\Services\ImportService;
use Illuminate\Http\Request;

class ImportExportController extends ApiController
{

    /**
     * Constructs a new instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function imports(ImportCsvFileRequest $request)
    {
        $importService = new ImportService();
        $importService->proccess($request);
        return response()->json(['message' => __('Data imported successfully')]);
    }

    public function export(Request $request)
    {
        $exportService = new ExportService();
        return $exportService->proccess($request);
    }
}
