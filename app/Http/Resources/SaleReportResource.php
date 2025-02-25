<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'tracking' => $this->tracking,
            'cart_total_price' => $this->cart_total_price,
            'cart_total_cost' => $this->cart_total_cost,
            'payable_after_all' => $this->payable_after_all,
            'discount_rate' => $this->discount_rate,
            'discount_amount' => $this->discount_amount,
            'profit_after_all' => $this->profit_after_all,
            'tax_amount' => $this->tax_amount,
            'customer' => new PosCustomerResource($this->customer),
            'progress' => $this->progress,
            'created_at' => $this->updated_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
        return $order;
    }
}
