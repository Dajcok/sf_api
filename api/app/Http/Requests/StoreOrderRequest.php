<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreOrderRequest
 * @package App\Http\Requests
 *
 * @OA\Schema (
 *     title="StoreOrderRequest",
 *     description="Store Order Request",
 *     required={"restaurant_id", "created_by", "status", "total", "table_id"},
 *     @OA\Property(property="restaurant_id", type="integer", description="Restaurant ID"),
 *     @OA\Property(property="created_by", type="integer", description="User ID"),
 *     @OA\Property(property="status", type="string", description="Order status", enum={"ACTIVE", "CANCELED", "DONE"}),
 *     @OA\Property(property="total", type="number", description="Total amount"),
 *     @OA\Property(property="table_id", type="integer", description="Table ID"),
 *     @OA\Property(property="notes", type="string", description="Order notes")
 * )
 */
class StoreOrderRequest extends Request
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
            'restaurant_id' => 'required|exists:restaurants,id',
            'created_by' => 'required|exists:users,id',
            'status' => 'required|in:ACTIVE,CANCELED,DONE',
            'total' => 'required|numeric',
            'table_id' => 'required|integer|exists:tables,id',
            'notes' => 'nullable|string',
        ];
    }
}
