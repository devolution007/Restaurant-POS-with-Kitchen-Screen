<?php

namespace App\Http\Resources;

use App\Http\Resources\PosModifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PosFoodItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'image' => $this->getImage(),
            'sku' => $this->sku,
            'cost' => $this->cost,
            'price' => $this->price,
            'modifiers' => PosModifierResource::collection($this->getModifiers()),
            //'in_stock' => $this->getTotalInStock(),
            'in_stock' => 200,
        ];
    }
}
