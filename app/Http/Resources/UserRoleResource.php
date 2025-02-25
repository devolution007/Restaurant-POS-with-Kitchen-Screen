<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_primary' => $this->is_primary,
            'users' => $this->users()->count(),
            'permissions' => $this->permissions,
            'admin_access' => $this->admin_access,
            'ordertaking_access' => $this->ordertaking_access,
            'kitchendisplay_access' => $this->kitchendisplay_access,
            'billingdisplay_access' => $this->billingdisplay_access,
            'created_at' => $this->created_at->format(config('app.app_date_format')),
            'updated_at' => $this->updated_at->format(config('app.app_date_format')),
        ];
    }
}
