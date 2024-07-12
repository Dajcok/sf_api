<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateOrderRequest
 * @package App\Http\Requests
 *
 * @OA\Schema (
 *     title="UpdateOrderRequest",
 *     description="Update Order Request",
 *     required={},
 *     @OA\Property(property="status", type="string", description="Order status", enum={"ACTIVE", "CANCELED", "DONE"}),
 *     @OA\Property(property="notes", type="string", description="Order notes")
 * )
 */
class UpdateOrderRequest extends FormRequest
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
            'status' => 'in:ACTIVE,CANCELED,DONE',
            'notes' => 'string',
        ];
    }
}
