<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductGroupItem;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class ProductGroupItemSeeder extends Seeder
{
    public function run()
    {
        ProductGroupItem::create([
            'user_group_id' => UserGroup::first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
        ]);
        ProductGroupItem::create([
            'user_group_id' => UserGroup::first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
        ]);
    }
}
