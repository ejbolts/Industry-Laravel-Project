<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Industry_Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'industry_partner_id' => function() {
                return Industry_Partner::factory()->create()->id;
            },
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'students_needed' => fake()->numberBetween(1, 5),
        ];
    }
}
