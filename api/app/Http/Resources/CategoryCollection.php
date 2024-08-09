<?php

namespace App\Http\Resources;

use app\Http\Resources\Abstract\BaseCollection;
use Illuminate\Http\Request;

class CategoryCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function getSelfUrl(): string
    {
        return route('api.category.index');
    }
}
