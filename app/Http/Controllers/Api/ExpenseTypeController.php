<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ExpenseTypeStoreRequest;
use App\Http\Requests\ExpenseTypeUpdateRequest;
use App\Http\Resources\ExpenseTypeResource;
use App\Models\ExpenseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseTypeController extends ApiController
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
        $tables = ExpenseType::latest()->get();
        return response()->json(ExpenseTypeResource::collection($tables));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\ExpenseTypeStoreRequest  $request  The request
     *
     * @return     JsonResponse                                 The json response.
     */
    public function store(ExpenseTypeStoreRequest $request): JsonResponse
    {
        $expenseType = ExpenseType::create($request->validated());
        return response()->json([
            'message' => __('Data saved successfully'),
            'type' => $expenseType->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\ExpenseType  $expenseType  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function show(ExpenseType $expenseType): JsonResponse
    {
        return response()->json(new ExpenseTypeResource($expenseType));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\ExpenseTypeUpdateRequest  $request       The request
     * @param      \App\Models\ExpenseType                      $expenseType  The service table
     *
     * @return     JsonResponse                                  The json response.
     */
    public function update(ExpenseTypeUpdateRequest $request, ExpenseType $expenseType): JsonResponse
    {
        $expenseType->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given service table.
     *
     * @param      \App\Models\ExpenseType  $expenseType  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function destroy(ExpenseType $expenseType): JsonResponse
    {
        if ($expenseType->expenses->count() < 1) {
            $expenseType->delete();
            return response()->json(['message' => __('Data removed successfully')]);
        }
        return response()->json(['message' => __('This expense category is being used')], 422);
    }

    /**
     * Expenses types for certain forms
     *
     * @return     JsonResponse  The json response.
     */
    public function expenseTypes(): JsonResponse
    {
        return response()->json(ExpenseTypeResource::collection(ExpenseType::get()));
    }
}
