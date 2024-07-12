<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateRestaurantRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="UpdateRestaurantRequest",
 *     description="Update Restaurant Request",
 *     required={},
 *     @OA\Property(property="name", type="string", description="The name of the restaurant"),
 *     @OA\Property(property="formatted_address", type="string", description="The formatted address of the restaurant"),
 * )
 */
class UpdateRestaurantRequest extends FormRequest
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
            'name' => 'string',
            'formatted_address' => 'string',
        ];
    }
}
