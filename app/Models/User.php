<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function userGroup(): HasOne
    {
        return $this->hasOne(UserGroup::class, 'user_id');
    }
}
