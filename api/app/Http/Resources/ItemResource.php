<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class ItemResource extends BaseResource
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
            'price' => $this->resource->price,
            'ingredients' => $this->resource->ingredients,
            'restaurant_id' => $this->resource->restaurant_id,
        ];
    }
}
