<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ModifierStoreRequest;
use App\Http\Requests\ModifierUpdateRequest;
use App\Http\Resources\ModifierDetailsResource;
use App\Http\Resources\ModifierResource;
use App\Models\Modifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModifierController extends ApiController
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
        $modifiers = Modifier::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => ModifierResource::collection($modifiers->items()),
                'pagination' => $this->pagination($modifiers),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModifierStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $modifier = Modifier::create($validated);
        $this->syncIngredient($validated, $modifier);
        return response()->json([
            'message' => __('Data saved successfully'),
            'modifier' => $modifier->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\Modifier  $modifier  The modifier
     *
     * @return     JsonResponse          The json response.
     */
    public function show(Modifier $modifier): JsonResponse
    {
        return response()->json(new ModifierDetailsResource($modifier));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\ModifierUpdateRequest  $request   The request
     * @param      \App\Models\Modifier                      $modifier  The modifier
     *
     * @return     JsonResponse                              The json response.
     */
    public function update(ModifierUpdateRequest $request, Modifier $modifier): JsonResponse
    {
        $validated = $request->validated();
        $modifier->update($validated);
        $this->syncIngredient($validated, $modifier);
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     * Destroys the given modifier.
     *
     * @param      \App\Models\Modifier  $modifier  The modifier
     *
     * @return     JsonResponse          The json response.
     */
    public function destroy(Modifier $modifier): JsonResponse
    {
        $modifier->ingredients()->sync([]);
        $modifier->delete();
        return response()->json([
            'message' => __('Data removed successfully'),
        ]);
    }

    public function destroyBatch(Request $request): JsonResponse
    {
        $items = modifier::whereIn('id', $request->rows)->get();
        foreach ($items as $item) {
            $item->ingredients()->sync([]);
            $item->delete();
        }
        return response()->json(['message' => __('Data removed successfully')]);
    }

    protected function syncIngredient($validated, $modifier)
    {
        if ($validated['ingredients'] && count($validated['ingredients'])) {
            $modifier->ingredients()->sync([]);
            foreach ($validated['ingredients'] as $ingredient) {
                $modifier->ingredients()->attach([$ingredient['id'] => ['quantity' => $ingredient['quantity_using']]]);
            }
        }
    }
}
