<?php

namespace App\Http\Resources;

use app\Http\Resources\Abstract\BaseCollection;
use Illuminate\Http\Request;

class ItemCollection extends BaseCollection
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
}
