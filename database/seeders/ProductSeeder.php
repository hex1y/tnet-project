<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    public function run()
    {
        $prices = [10, 15, 8, 7, 20];

        $user = User::first()->id;

        for ($i = 0; $i < 5; $i++) {
            $num = $i + 1;

            Product::create([
                'user_id' => $user,
                'title' => "Product $num",
                'price' => $prices[$i],
            ]);
        }
    }
}
