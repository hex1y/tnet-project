<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        UserGroup::create([
            'user_id' => User::first()->id,
            'discount' => 15,
        ]);
    }
}
