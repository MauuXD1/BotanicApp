<?php

declare(strict_types=1);

namespace App\Models;

//use Jenssegers\Mongodb\Auth\User as Authenticatable;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Mutator para hashear la contraseña al guardarla
    public function setPasswordAttribute($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        // Evita volver a hashear si ya está hasheada
        if (password_get_info($value)['algo'] === 0) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}