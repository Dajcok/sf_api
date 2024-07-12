<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRestaurantRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="StoreRestaurantRequest",
 *     description="Store Restaurant Request",
 *     required={"name", "formatted_address"},
 *     @OA\Property(property="name", type="string", description="The name of the restaurant"),
 *     @OA\Property(property="formatted_address", type="string", description="The formatted address of the restaurant"),
 * )
 */
class StoreRestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'formatted_address' => 'required|string',
        ];
    }
}
