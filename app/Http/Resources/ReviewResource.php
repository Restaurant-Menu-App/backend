<?php

namespace App\Http\Resources;

use App\Http\Resources\V1\RestaurantResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'comment' => $this->comment,
            'restaurant' => new RestaurantResource($this->restaurant),
            'user' => new UserResource($this->user),
            'star_rating' => $this->star_rating,
            'review_time' => $this->created_at->diffForHumans()
        ];
    }
}
