<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'nickname',
        'email',
        'password',
        'phone_number',
        'img_url',
        'status',
        'information'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }

    public function roles()
    {
        // return $this->belongsToMany(Role::class);
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($roles): bool
    {
        // Jika $roles adalah array, periksa apakah user memiliki salah satu role
        if (is_array($roles)) {
            return $this->roles()->whereIn('name', $roles)->exists();
        }

        // Jika $roles adalah string, periksa apakah user memiliki role tersebut
        return $this->roles()->where('name', $roles)->exists();
    }
}
