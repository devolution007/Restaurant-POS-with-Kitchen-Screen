<?php

namespace App\Http\Resources;

use App\Http\Resources\FoodCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'alert_at' => $this->low_qty_alert,
            'cost' => $this->cost,
            'price' => $this->price,
            'category' => new FoodCategoryResource($this->category),
            'image' => $this->getImage(),
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
