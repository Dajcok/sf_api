<?php

namespace App\Http\Resources;

use app\Http\Resources\Abstract\BaseCollection;
use Illuminate\Http\Request;

class OrderCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    /**
     * @inheritDoc
     */
    public function getSelfUrl(): string
    {
        return route('api.order.index');
    }
}
