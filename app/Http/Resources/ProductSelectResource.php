<?php

namespace App\Http\Resources;

use App\Http\Resources\ProductAttributeSelectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSelectResource extends JsonResource
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
            'status' => $this->status,
            'avatar' => $this->getImage(),
            'has_variants' => $this->has_variants,
            'attributes' => ProductAttributeSelectResource::collection($this->productAttributes),
        ];
    }
}
