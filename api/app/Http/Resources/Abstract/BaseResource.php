<?php

namespace App\Http\Resources\Abstract;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class BaseResource extends JsonResource
{
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
