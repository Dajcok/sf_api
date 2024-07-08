<?php

namespace App\Models;

use Eloquent;
use Hash;
use Log;
use App\DTO\Input\Auth\UserCreateInputData;
use Carbon\Carbon;
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
 *     required={"name", "email", "password"},
 *     @OA\Property(property="id", type="integer", format="int64", description="ID"),
 *     @OA\Property(property="name", type="string", description="User name"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="password", type="string", format="password", description="User password"),
 *     @OA\Property(property="is_admin", type="boolean", description="Is user admin"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation date"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update date")
 * )
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the isAdmin attribute.
     *
     * @return bool
     */
    public function getIsAdminAttribute(): bool
    {
        return (bool)$this->attributes['is_admin'];
    }

    /**
     * Private setter for the isAdmin attribute.
     *
     * @param bool $value
     * @return void
     */
    private function setIsAdminAttribute(bool $value): void
    {
        $this->attributes['is_admin'] = $value;
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Create superuser
     *
     * @param UserCreateInputData $data
     * @return User
     */
    public static function createSuperuser(UserCreateInputData $data): User
    {
        $user = self::create([
            ...$data->toArray(),
            'email_verified_at' => Carbon::now(),
        ]);

        $user->is_admin = true;
        $user->save();

        Log::info('Superuser created', ['email' => $data->email]);

        return $user;
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
