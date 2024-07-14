<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class RestaurantResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'formatted_address' => $this->resource->formatted_address,
        ];
    }
}
