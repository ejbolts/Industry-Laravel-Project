<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry_Partner;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $industryPartners = Industry_Partner::all();

        foreach ($industryPartners as $industryPartner) {
            foreach (range(1, 2) as $index) { // 2 projects per industry partner
                Project::create([
                    'industry_partner_id' => $industryPartner->id,
                    'title' => "Project $index of " . $industryPartner->name,
                    'description' => "Description for Project $index of " . $industryPartner->name,
                    'team_size' => rand(3, 5),
                    'trimester' => rand(1, 3),
                    'year' => date('Y'),
                ]);
            }
        }
    }
}
