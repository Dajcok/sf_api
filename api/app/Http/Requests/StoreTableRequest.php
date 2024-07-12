<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreTableRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="StoreTableRequest",
 *     description="Store Table Request",
 *     required={"restaurant_id", "number", "x", "y"},
 *     @OA\Property(property="restaurant_id", type="integer", description="The id of the restaurant"),
 *     @OA\Property(property="number", type="integer", description="The number of the table"),
 *     @OA\Property(property="x", type="number", description="The x position of the table"),
 *     @OA\Property(property="y", type="number", description="The y position of the table"),
 * )
 */
class StoreTableRequest extends FormRequest
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
            'restaurant_id' => 'required|integer|exists:restaurants,id',
            'number' => 'required|integer',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ];
    }
}
