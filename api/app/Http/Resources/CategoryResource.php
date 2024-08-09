<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstract\BaseResource;
use Illuminate\Http\Request;

class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code_name' => $this->code_name,
            'label' => $this->label,
        ];
    }
}
