<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductGroupItem extends Model
{

    protected $fillable = [
        'user_group_id',
        'product_id',
    ];

    public function userGroup(): BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
