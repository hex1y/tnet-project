<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserGroup extends Model
{

    protected $fillable = [
        'user_id',
        'user_group_id',
        'discount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productGroupItems(): HasMany
    {
        return $this->hasMany(ProductGroupItem::class, 'user_group_id');
    }

}
