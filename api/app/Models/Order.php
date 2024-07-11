<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Eloquent
 * @OA\Schema(
 *     title="Order",
 *     description="Order model",
 *     @OA\Property(property="id", type="integer", description="The order's ID", example="1"),
 *     @OA\Property(property="total", type="number", description="The order's total", example="100.00"),
 *     @OA\Property(property="status", type="string", description="The order's status", example="pending"),
 *     @OA\Property(property="created_at", type="string", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", description="Last update date")
 * )
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'status',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_order');
    }
}
