<?php

namespace app\Http\Resources\Abstract;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
abstract class BaseCollection extends ResourceCollection
{
    public function __construct($resource = [])
    {
        parent::__construct($resource);
    }

    /**
     * Get the self URL for the resource collection.
     *
     * @return string
     */
    abstract public function getSelfUrl(): string;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'items' => $this->resource->items(),
                'links' => [
                    'self' => $this->getSelfUrl(),
                    'pagination' => [
                        'next' => $this->resource->nextPageUrl(),
                        'prev' => $this->resource->previousPageUrl(),
                    ],
                ],
                'pagination' => [
                    'total' => $this->resource->total(),
                    'count' => $this->resource->count(),
                    'per_page' => $this->resource->perPage(),
                    'current_page' => $this->resource->currentPage(),
                    'total_pages' => $this->resource->lastPage(),
                ],
            ];
        }

        return [
            'items' => $this->collection,
            'links' => [
                'self' => $this->getSelfUrl(),
            ],
        ];
    }
}
