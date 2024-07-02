<?php

namespace App\Models;

use App\DTO\Input\UserCreateInputData;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
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
     * Create superuser
     *
     * @param UserCreateInputData $data
     * @return User
     */
    public static function createSuperuser(UserCreateInputData $data): User
    {
        $user = self::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'email_verified_at' => Carbon::now(),
        ]);

        $user->setIsAdminAttribute(true);
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
