<?php

namespace App\Http\Resources;

use App\Http\Resources\FoodCategoryResource;
use App\Http\Resources\IngredientWithPivotResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->getImage(),
            'category' => new FoodCategoryResource($this->category),
            'price' => $this->price,
            'cost' => $this->cost,
            'sku' => $this->sku,
            'description' => $this->description,
            'ingredients' => IngredientWithPivotResource::collection($this->ingredients),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
            'created_at' => $this->created_at->format(config('app.app_date_format')),
        ];
    }
}
