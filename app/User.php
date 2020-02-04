<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLED = 'disabled';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function rolesList(): array
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_USER => 'User'
        ];
    }

    public static function statusesList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DISABLED => 'Disabled'
        ];
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDisabled()
    {
        return $this->status === self::STATUS_DISABLED;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    // добавление пользователя
    public static function register(string $name, string $email, string $password): self
    {

        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => self::ROLE_USER,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    // перключение статуса пользователя
    public function switchStatus(): void
    {
        $this->update(['status' => $this->isActive() ? self::STATUS_DISABLED : self::STATUS_ACTIVE]);
    }

    public function changeRole($role): void
    {
        if (!in_array($role, [self::ROLE_USER, self::ROLE_ADMIN], true)) {
            throw new \InvalidArgumentException('Undefined role "' . $role . '"');
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }
}
