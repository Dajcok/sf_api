<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 *
 * @OA\Schema(
 *     title="Restaurant",
 *     description="Restaurant model",
 *     @OA\Property(property="id", type="integer", description="The restaurant's ID", example="1"),
 *     @OA\Property(property="name", type="string", description="The restaurant's name", example="Restaurant Name"),
 *     @OA\Property(property="formatted_address", type="string", description="The restaurant's formatted address", example="123 Main St, City, State, Zip")
 * )
 */
class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'formatted_address',
    ];
}
