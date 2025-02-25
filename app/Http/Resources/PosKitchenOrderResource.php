<?php

namespace App\Http\Resources;

use App\Http\Resources\ServiceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PosKitchenOrderResource extends JsonResource
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
            'tracking' => $this->tracking,
            'items' => $this->items,
            'table' => new ServiceTableResource($this->serviceTable),
            'customer' => new PosCustomerResource($this->customer),
            'chef_id' => $this->chef_id,
            'order_type' => $this->order_type,
            'took_at' => $this->took_at,
            'note_for_chef' => $this->note_for_chef,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
