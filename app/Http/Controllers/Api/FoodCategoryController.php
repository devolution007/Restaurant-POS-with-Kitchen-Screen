<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\FoodCategoryStoreRequest;
use App\Http\Requests\FoodCategoryUpdateRequest;
use App\Http\Resources\FoodCategoryResource;
use App\Models\FoodCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FoodCategoryController extends ApiController
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
        $categories = FoodCategory::filter($request->all())
            ->orderBy($sort['column'], $sort['order'])
            ->paginate((int) $request->get('perPage', 10));
        return response()->json(
            [
                'items' => FoodCategoryResource::collection($categories->items()),
                'pagination' => $this->pagination($categories),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param      \App\Http\Requests\FoodCategoryStoreRequest  $request  The request
     *
     * @return     JsonResponse                             The json response.
     */
    public function store(FoodCategoryStoreRequest $request): JsonResponse
    {
        $foodCategory = FoodCategory::create($this->categoryValidated($request));
        return response()->json([
            'message' => __('Data saved successfully'),
            'category' => new FoodCategoryResource($foodCategory),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param      \App\Models\FoodCategory  $foodCategory  The category
     *
     * @return     JsonResponse          The json response.
     */
    public function show(FoodCategory $foodCategory): JsonResponse
    {
        return response()->json(new FoodCategoryResource($foodCategory));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param      \App\Http\Requests\FoodCategoryUpdateRequest  $request   The request
     * @param      \App\Models\FoodCategory                      $foodCategory  The category
     *
     * @return     JsonResponse                              The json response.
     */
    public function update(FoodCategoryUpdateRequest $request, FoodCategory $foodCategory): JsonResponse
    {
        $foodCategory->update($this->categoryValidated($request));
        return response()->json([
            'message' => __('Data updated successfully'),
        ]);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param      \App\Models\Category  $foodCategory  The category
     *
     * @return     JsonResponse          The json response.
     */
    public function destroy(FoodCategory $foodCategory): JsonResponse
    {
        $foodCategory->delete();
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Categories list for certain forms
     *
     * @return     JsonResponse  The json response.
     */
    public function categories(): JsonResponse
    {
        return response()->json(FoodCategoryResource::collection(FoodCategory::get()));
    }

    public function destroyBatch(Request $request): JsonResponse
    {
        $categories = FoodCategory::whereIn('id', $request->rows)->get();
        foreach ($categories as $key => $category) {
            $category->products()->delete();
            $category->delete();
        }
        return response()->json(['message' => __('Data removed successfully')]);
    }

    /**
     * Category request validation
     *
     * @param      Object  $request  The request
     *
     * @return     Array   Validated request
     */
    protected function categoryValidated($request): array
    {
        $data = $request->validated();
        if ($request->file('image')) {
            $data['image'] = $request->file('image')
                ->store('repairing/categories', 'public');
        }
        return $data;
    }
}
