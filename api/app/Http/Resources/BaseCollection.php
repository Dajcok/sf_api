<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     schema="BaseCollection",
 *     type="object",
 *     title="BaseCollection",
 *     description="Base collection model",
 *     @OA\Property(property="links", type="object", description="Links")
 * )
 */
class BaseCollection extends ResourceCollection
{
    //TODO: Pagination

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
