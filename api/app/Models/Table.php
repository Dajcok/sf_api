<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 *
 * @OA\Schema(
 *     title="Table",
 *     description="Table model",
 *     @OA\Property(property="id", type="integer", description="The table's ID", example="1"),
 *     @OA\Property(property="number", type="integer", description="The table's number", example="1"),
 *     @OA\Property(property="x", type="integer", description="The table's x coordinate", example="1"),
 *     @OA\Property(property="y", type="integer", description="The table's y coordinate", example="1"),
 * )
 */
class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'x',
        'y',
    ];
}
