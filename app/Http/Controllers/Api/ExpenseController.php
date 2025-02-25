<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends ApiController
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
        $sort = $this->sort($request);
        $expenses = Expense::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => ExpenseResource::collection($expenses->items()),
                'pagination' => $this->pagination($expenses),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\ExpenseStoreRequest  $request  The request
     *
     * @return     JsonResponse                                 The json response.
     */
    public function store(ExpenseStoreRequest $request): JsonResponse
    {
        $expense = Expense::create($request->validated());
        return response()->json([
            'message' => __('Data saved successfully'),
            'expense' => $expense->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\Expense  $expense  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function show(Expense $expense): JsonResponse
    {
        return response()->json(new ExpenseResource($expense));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\ExpenseUpdateRequest  $request       The request
     * @param      \App\Models\Expense                      $expense  The service table
     *
     * @return     JsonResponse                                  The json response.
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense): JsonResponse
    {
        $expense->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given service table.
     *
     * @param      \App\Models\Expense  $expense  The service table
     *
     * @return     JsonResponse              The json response.
     */
    public function destroy(Expense $expense): JsonResponse
    {
        $expense->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Expenses types for certain forms
     *
     * @return     JsonResponse  The json response.
     */
    public function expenses(): JsonResponse
    {
        return response()->json(ExpenseResource::collection(Expense::get()));
    }

    public function destroyBatch(Request $request): JsonResponse
    {
        $items = Expense::whereIn('id', $request->rows)->get();
        foreach ($items as $key => $item) {
            $item->delete();
        }
        return response()->json(['message' => __('Data removed successfully')]);
    }
};
