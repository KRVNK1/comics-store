<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status_user',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->status_user == 1;
    }

    public function cartItems()
{
    return $this->hasMany(Cart::class);
}

public function favourites()
{
    return $this->hasMany(Favourite::class);
}

public function orders()
{
    return $this->hasMany(Order::class);
}

public function usedPromocodes(): BelongsToMany
{
    return $this->belongsToMany(Promocode::class, 'promocode_usages')
               ->withPivot('order_id')
               ->withTimestamps();
}
}