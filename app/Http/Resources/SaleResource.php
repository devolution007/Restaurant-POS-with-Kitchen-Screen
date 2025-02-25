<?php

namespace App\Http\Resources;

use App\Http\Resources\PosCustomerResource;
use App\Http\Resources\PosServiceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'tracking' => $this->tracking,
            'cart_total_cost' => $this->cart_total_cost,
            'cart_total_price' => $this->cart_total_price,
            'tax_amount' => $this->tax_amount,
            'shipping' => $this->shipping,
            'order_type' => $this->order_type,
            'progress' => $this->progress,
            'customer' => new PosCustomerResource($this->customer),
            'table' => new PosServiceTableResource($this->serviceTable),
            'took_at' => $this->took_at,
            'prepared_at' => $this->prepared_at,
            'completed_at' => $this->completed_at,
            'created_at' => $this->updated_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
