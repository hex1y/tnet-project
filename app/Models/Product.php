<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{

    protected $fillable = [
        'user_id',
        'title',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productGroupItem(): HasOne
    {
        return $this->hasOne(ProductGroupItem::class, 'product_id');
    }

}
