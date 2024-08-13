<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 *
 * @OA\Schema(
 *     title="Category",
 *     description="Category model",
 *     @OA\Property(property="id", type="integer", description="The category's ID", example="1"),
 *     @OA\Property(property="name", type="string", description="The category's name", example="Category Name"),
 *     @OA\Property(property="label", type="string", description="The category's label", example="Category Label"),
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_name',
        'label',
        'restaurant_id',
    ];

    /**
     * Get the items for the category.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
