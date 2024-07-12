<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", format="int64", description="ID"),
 *     @OA\Property(property="name", type="string", description="User name"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="password", type="string", format="password", description="User password"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date"),
 *     @OA\Property(property="restaurant_id", type="integer", description="Restaurant ID"),
 * )
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_anonymous',
        'role',
        'restaurant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
        'is_anonymous',
        'role',
        'is_admin',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * {@inheritdoc}
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'is_anonymous' => 'boolean',
            'role' => 'string',
        ];
    }

    /**
     * Hashes and sets the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
