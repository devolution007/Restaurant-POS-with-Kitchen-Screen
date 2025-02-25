<?php

namespace App\Http\Resources;

use App\Http\Resources\IngredientWithPivotResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModifierDetailsResource extends JsonResource
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
            'title' => $this->title,
            'price' => $this->price,
            'cost' => $this->cost,
            'ingredients' => IngredientWithPivotResource::collection($this->ingredients),
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
