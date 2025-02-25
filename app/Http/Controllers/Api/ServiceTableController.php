<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ServiceTableStoreRequest;
use App\Http\Requests\ServiceTableUpdateRequest;
use App\Http\Resources\ServiceTableResource;
use App\Models\ServiceTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceTableController extends ApiController
{

    /**
     * Construct middleware and initiated backups list
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo')->only(['update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     JsonResponse              The json response.
     */
    public function index(Request $request): JsonResponse
    {
        $tables = ServiceTable::latest()->get();
        return response()->json(ServiceTableResource::collection($tables));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\ServiceTableStoreRequest  $request  The request
     *
     * @return     JsonResponse                                 The json response.
     */
    public function store(ServiceTableStoreRequest $request): JsonResponse
    {
        $serviceTable = ServiceTable::create($request->validated());
        return response()->json([
            'message' => __('Data saved successfully'),
            'table' => $serviceTable->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\ServiceTable  $serviceTable  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function show(ServiceTable $serviceTable): JsonResponse
    {
        return response()->json(new ServiceTableResource($serviceTable));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\ServiceTableUpdateRequest  $request       The request
     * @param      \App\Models\ServiceTable                      $serviceTable  The service table
     *
     * @return     JsonResponse                                  The json response.
     */
    public function update(ServiceTableUpdateRequest $request, ServiceTable $serviceTable): JsonResponse
    {
        $serviceTable->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given service table.
     *
     * @param      \App\Models\ServiceTable  $serviceTable  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function destroy(ServiceTable $serviceTable): JsonResponse
    {
        $serviceTable->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Service tables list for certain forms
     *
     * @return     JsonResponse  The json response.
     */
    public function serviceTables(): JsonResponse
    {
        return response()->json(ServiceTableResource::collection(ServiceTable::get()));
    }

}
