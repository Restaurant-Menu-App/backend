<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'website_url' => $this->website_url,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'priority' => $this->priority,
            'desc' => $this->desc,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'join_at' => $this->create_at->diffForHumans()
        ];
    }
}
