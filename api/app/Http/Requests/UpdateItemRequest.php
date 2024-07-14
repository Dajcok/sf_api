<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateItemRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="UpdateItemRequest",
 *     description="Update Item Request",
 *     required={},
 *     @OA\Property(property="name", type="string", example="Pizza"),
 *     @OA\Property(property="price", type="number", example="10.99"),
 *     @OA\Property(property="ingredients", type="string", example="Tomato, Cheese, Pepperoni"),
 * )
 */
class UpdateItemRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'price' => 'numeric',
            'ingredients' => 'string',
        ];
    }
}
