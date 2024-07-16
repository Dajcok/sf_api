<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Class StoreOrderRequest
 * @package App\Http\Requests
 *
 * @OA\Schema (
 *     title="StoreOrderRequest",
 *     description="Store Order Request",
 *     required={"restaurant_id", "table_id", "items"},
 *     @OA\Property(property="restaurant_id", type="integer", description="Restaurant ID"),
 *     @OA\Property(property="table_id", type="integer", description="Table ID"),
 *     @OA\Property(property="notes", type="string", description="Order notes", nullable=true),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             required={"item_id", "qty"},
 *             @OA\Property(property="item_id", type="integer", description="Item ID"),
 *             @OA\Property(property="qty", type="integer", description="Quantity")
 *         )
 *     )
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => $this->user()->id,
            'status' => OrderStatusEnum::ACTIVE->value,
        ]);
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
            'table_id' => 'required|integer|exists:tables,id',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|integer|exists:items,id',
            'items.*.qty' => 'required|integer|min:1'
        ];
    }
}
