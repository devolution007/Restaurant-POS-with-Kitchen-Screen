<?php

namespace App\Http\Resources;

use App\Http\Resources\PosCustomerResource;
use App\Http\Resources\PosServiceTableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PosSubmittedSaleOrderResource extends JsonResource
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
            'customer' => new PosCustomerResource($this->customer),
            'service_table' => new PosServiceTableResource($this->serviceTable),
            'payable_after_all' => $this->payable_after_all,
            'order_type' => $this->order_type,
            'progress' => $this->progress,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
