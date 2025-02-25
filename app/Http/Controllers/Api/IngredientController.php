<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\IngredientStoreRequest;
use App\Http\Requests\IngredientUpdateRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends ApiController
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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $ingredients = Ingredient::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => IngredientResource::collection($ingredients->items()),
                'pagination' => $this->pagination($ingredients),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientStoreRequest $request): JsonResponse
    {
        $ingredient = Ingredient::create($request->validated());
        return response()->json([
            'message' => __('Data saved successfully'),
            'ingredient' => $ingredient->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient): JsonResponse
    {
        return response()->json(new IngredientResource($ingredient));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\IngredientUpdateRequest  $request     The request
     * @param      \App\Models\Ingredient                      $ingredient  The ingredient
     *
     * @return     JsonResponse                                The json response.
     */
    public function update(IngredientUpdateRequest $request, Ingredient $ingredient): JsonResponse
    {
        $ingredient->update($request->validated());
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $ingredient): JsonResponse
    {
        if ($ingredient->ingredientIsBeingUsed()) {
            $ingredient->delte();
            return response()->json([
                'message' => __('Data removed successfully'),
            ]);
        }
        return response()->json([
            'message' => __('This ingredient is being used for food items or modifiers'),
        ], 422);
    }

    public function destroyBatch(Request $request): JsonResponse
    {
        $items = Ingredient::whereIn('id', $request->rows)->get();
        foreach ($items as $key => $item) {
            if ($item->ingredientIsBeingUsed()) {
                $item->delete();
            }
        }
        return response()->json(['message' => __('Data removed successfully')]);
    }

    public function getList(): JsonResponse
    {
        $ingredients = Ingredient::get();
        return response()->json(
            IngredientResource::collection($ingredients)
        );
    }
}
