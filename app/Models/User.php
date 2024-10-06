<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Authorizable;

    protected $fillable = [
        'name', 'email', 'password', 'cargo', 'matricula', 'profile_img',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($user) {
    //         $user->matricula = 'MT-' . Str::upper(Str::random(6));
    //     });
    // }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
