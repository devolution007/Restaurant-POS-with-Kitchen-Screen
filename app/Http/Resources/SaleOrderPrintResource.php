<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderPrintResource extends JsonResource
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
            'items' => $this->items,
            'cart_total_price' => $this->cart_total_price,
            'cart_total_cost' => $this->cart_total_cost,
            'payable_after_all' => $this->payable_after_all,
            'discount_rate' => $this->discount_rate,
            'discount_amount' => $this->discount_amount,
            'profit_after_all' => $this->profit_after_all,
            'order_type' => $this->order_type,
            'tax' => $this->tax,
            'tax_amount' => $this->tax_amount,
            'customer' => new PosCustomerResource($this->customer),
            'table' => new PosServiceTableResource($this->serviceTable),
            'took_at' => $this->took_at,
            'progress' => $this->progress,
            'created_at' => $this->updated_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
