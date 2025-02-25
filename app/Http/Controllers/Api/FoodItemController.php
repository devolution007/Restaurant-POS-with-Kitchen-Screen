<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\FoodItemStoreRequest;
use App\Http\Requests\FoodItemUpdateRequest;
use App\Http\Resources\FoodItemDetailResource;
use App\Http\Resources\FoodItemResource;
use App\Models\FoodItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodItemController extends ApiController
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
     * @return     JsonResponse  The json response.
     */
    public function index(Request $request): JsonResponse
    {
        $sort = $this->sort($request);
        $foodItems = FoodItem::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => FoodItemResource::collection($foodItems->items()),
                'pagination' => $this->pagination($foodItems),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\FoodItemStoreRequest  $request  The request
     *
     * @return     JsonResponse                            The json response.
     */
    public function store(FoodItemStoreRequest $request): JsonResponse
    {
        $validated = $this->itemValidated($request);
        $validated['uuid'] = \Str::orderedUuid();
        $foodItem = FoodItem::create($validated);
        $this->syncIngredient($validated, $foodItem);
        return response()->json([
            'message' => __('Data saved successfully'),
            'item' => $foodItem->uuid,
        ]);
    }

    /**
     *  Display the specified resource.
     *
     * @param      \App\Models\FoodItem  $foodItem  The fooditem
     *
     * @return     JsonResponse         The json response.
     */
    public function show(FoodItem $foodItem): JsonResponse
    {
        return response()->json(new FoodItemDetailResource($foodItem));
    }

    /**
     * Update the specified resource in storage
     *
     * @param      \App\Http\Requests\FoodItemUpdateRequest  $request  The request
     * @param      \App\Models\FoodItem                      $foodItem  The product
     *
     * @return     JsonResponse                             The json response.
     */
    public function update(FoodItemUpdateRequest $request, FoodItem $foodItem): JsonResponse
    {
        $validated = $this->itemValidated($request);
        $this->syncIngredient($validated, $foodItem);
        $foodItem->update($validated);
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given product.
     *
     * @param      \App\Models\FoodItem  $foodItem  The product
     *
     * @return     JsonResponse         The json response.
     */
    public function destroy(FoodItem $foodItem): JsonResponse
    {
        $foodItem->ingredients()->sync([]);
        $foodItem->delete();
        return response()->json([
            'message' => __('Data removed successfully'),
        ]);
    }

    public function destroyBatch(Request $request): JsonResponse
    {
        $items = FoodItem::whereIn('uuid', $request->rows)->get();
        foreach ($items as $item) {
            $item->ingredients()->sync([]);
            $item->delete();
        }
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Food item request validation
     *
     * @param      Object  $request  The request
     *
     * @return     Array   Validated request
     */
    protected function itemValidated($request): array
    {
        $validated = $request->validated();
        $validated['ingredients'] = json_decode($validated['ingredients']);
        $validated['sku'] = $request->sku ?? \Str::sku($request->name);
        if ($request->file('image')) {
            $validated['image'] = $request->file('image')
                ->store('food-items', 'public');
        }
        return $validated;
    }

    protected function syncIngredient($validated, $foodItem)
    {
        if ($validated['ingredients'] && count($validated['ingredients'])) {
            $foodItem->ingredients()->sync([]);
            foreach ($validated['ingredients'] as $ingredient) {
                $foodItem->ingredients()->attach([$ingredient->id => ['quantity' => $ingredient->quantity_using]]);
            }
        }
    }
}
