<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Eloquent
 *
 * @OA\Schema(
 *     title="Item",
 *     description="Item model",
 *     @OA\Property(property="id", type="integer", description="The item's ID", example="1"),
 *     @OA\Property(property="name", type="string", description="The item's name", example="Item Name"),
 *     @OA\Property(property="price", type="number", description="The item's price", example="10.00"),
 *     @OA\Property(property="ingredients", type="string", description="The item's ingredients", example="Ingredient 1, Ingredient 2"),
 * )
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'ingredients',
        'restaurant_id',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'item_order');
    }
}
