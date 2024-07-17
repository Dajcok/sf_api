<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     title="Order",
 *     description="Order model",
 *     @OA\Property(property="id", type="integer", description="The order's ID", example="1"),
 *     @OA\Property(property="total", type="number", description="The order's total", example="100.00"),
 *     @OA\Property(property="status", type="string", description="The order's status", example="pending"),
 *     @OA\Property(property="created_at", type="string", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", description="Last update date"),
 *     @OA\Property(property="table_id", type="integer", description="The table's ID", example="1"),
 *     @OA\Property(property="notes", type="string", description="The order's notes", example="Extra ketchup"),
 *     @OA\Property(property="restaurant_id", type="integer", description="The restaurant's ID", example="1"),
 * )
 */
class Order extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'status',
        'table_id',
        'notes',
        'created_by'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * {@inheritdoc}
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'restaurant_id' => 'integer',
            'status' => 'string',
            'table_id' => 'integer',
            'notes' => 'string',
            'created_by' => 'integer'
        ];
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_order')
            ->using(ItemOrder::class)
            ->withPivot('qty')
            ->withTimestamps();
    }
}
