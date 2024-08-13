<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class StoreItemRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="StoreItemRequest",
 *     description="Store Item Request",
 *     required={"name", "price", "ingredients", "restaurant_id"},
 *     @OA\Property(property="name", type="string", example="Pizza"),
 *     @OA\Property(property="price", type="number", example="10.99"),
 *     @OA\Property(property="ingredients", type="string", example="Tomato, Cheese, Pepperoni"),
 *     @OA\Property(property="restaurant_id", type="number", example="1")
 * )
 */
class StoreItemRequest extends Request
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'ingredients' => 'required|string',
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id' => 'exists:categories,id'
        ];
    }
}
