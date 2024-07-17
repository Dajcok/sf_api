<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class OrderResource extends BaseResource
{
    /**
     * Calculate the total of the order.
     *
     * @return float
     */
    protected function calculateTotal(): float
    {
        return $this->resource->items->reduce(function ($carry, $item) {
            return $carry + $item->price * $item->pivot->qty;
        }, 0);
    }

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
            'total' => $this->calculateTotal(),
            'items' => $this->resource->items,
            'restaurant_id' => $this->resource->restaurant_id,
            'created_by' => $this->resource->created_by,
            'table_id' => $this->resource->table_id,
            'notes' => $this->resource->notes,
        ];
    }
}
