<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreOrderRequest
 * @package App\Http\Requests
 *
 * @OA\Schema (
 *     title="StoreOrderRequest",
 *     description="Store Order Request",
 *     required={"restaurant_id", "notes", "table_id", "items"},
 *     @OA\Property(property="restaurant_id", type="integer", description="Restaurant ID"),
 *     @OA\Property(property="table_id", type="integer", description="Table ID"),
 *     @OA\Property(property="notes", type="string", description="Order notes")
 *     @OA\Property(property="items", type="array", @OA\Items(type="integer")),
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
            'table_id' => 'required|integer|exists:tables,id',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*' => 'integer|exists:items,id'
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @param null $key
     * @param null $default
     * @return array
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();
        $validated['created_by'] = $this->user()->id;
        $validated['status'] = OrderStatusEnum::ACTIVE->value;

        return $validated;
    }
}
