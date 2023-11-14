<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Industry_Partner;

class IndustryPartnerSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 6) as $index) {
            $user = User::create([
                'name' => "Industry Partner $index",
                'email' => "industrypartner$index@example.com",
                'password' => bcrypt('password'),
                'type' => 'industry_partner',
            ]);

            Industry_Partner::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_approved' => false,
            ]);
        }
    }
}
