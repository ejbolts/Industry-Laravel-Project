<?php
namespace Database\Factories;

use App\Models\Industry_Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IndustryPartnerFactory extends Factory
{
    protected $model = Industry_Partner::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            // ... other fields ...
        ];
    }
}


