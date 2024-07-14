<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class OrderResource extends BaseResource
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
            'status' => $this->resource->status,
            'total' => $this->resource->total,
            'items' => $this->resource->items,
            'restaurant_id' => $this->resource->restaurant_id,
            'created_by' => $this->resource->created_by,
            'table_id' => $this->resource->table_id,
            'created_at' => $this->resource->created_at,
        ];
    }
}
