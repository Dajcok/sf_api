<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class TableResource extends BaseResource
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
            'number' => $this->resource->number,
            'restaurant_id' => $this->resource->restaurant_id,
            'x' => $this->resource->x,
            'y' => $this->resource->y,
        ];
    }
}
