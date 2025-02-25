<?php

namespace App\Http\Resources;

use App\Http\Resources\PosCustomerResource;
use App\Http\Resources\PosServiceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PosBillingSaleOrderResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'items' => $this->items,
            'cart_total_price' => $this->cart_total_price,
            'cart_total_cost' => $this->cart_total_cost,
            'payable_after_all' => $this->payable_after_all,
            'discount_rate' => $this->discount_rate,
            'discount_amount' => $this->discount_amount,
            'service_table' => new PosServiceTableResource($this->serviceTable),
            'customer' => new PosCustomerResource($this->customer),
            'order_type' => $this->order_type,
            'recipient_amount' => 0,
            'payment_method_id' => $this->payment_method_id ?? 1,
            'tax' => $this->tax,
            'tax_amount' => $this->tax_amount,
            'progress' => $this->progress,
            'payment_note' => $this->payment_note,
            'staff_note' => $this->staff_note,
            'note_for_chef' => $this->note_for_chef,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
