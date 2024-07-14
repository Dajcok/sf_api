<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateTableRequest
 * @package App\Http\Requests
 *
 * @OA\Schema(
 *     title="UpdateTableRequest",
 *     description="Update Table Request",
 *     required={},
 *     @OA\Property(property="number", type="integer", description="The number of the table"),
 *     @OA\Property(property="x", type="number", description="The x position of the table"),
 *     @OA\Property(property="y", type="number", description="The y position of the table"),
 * )
 */
class UpdateTableRequest extends Request
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
            'number' => 'integer',
            'x' => 'numeric',
            'y' => 'numeric',
        ];
    }
}
