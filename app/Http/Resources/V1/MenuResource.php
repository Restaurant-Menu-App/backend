<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'desc' => $this->desc,
            'price' => $this->price,
            'priority' => $this->priority,
            'join_at' => $this->created_at->diffForHumans(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'restaurant' => new RestaurantResource($this->whenLoaded('restaurant')),

            //image
        ];
    }
}
