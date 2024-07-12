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
 *     @OA\Property(property="restaurant_id", type="integer", description="Restaurant ID"),
 *     @OA\Property(property="created_by", type="integer", description="User ID"),
 *     @OA\Property(property="status", type="string", description="Order status", enum={"ACTIVE", "CANCELED", "DONE"}),
 *     @OA\Property(property="total", type="number", description="Total amount"),
 *     @OA\Property(property="table_number", type="integer", description="Table number"),
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
            'restaurant_id' => 'exists:restaurants,id',
            'created_by' => 'exists:users,id',
            'status' => 'in:ACTIVE,CANCELED,DONE',
            'total' => 'numeric',
            'table_number' => 'integer',
            'notes' => 'string',
        ];
    }
}
