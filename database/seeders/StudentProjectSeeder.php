<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Student;
use App\Models\Project;

class StudentProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        $projects = Project::all();

        foreach ($students as $student) {
            // Get 1 random projects for each student to apply to
            $randomProjects = $projects->random(rand(1, 1));

            foreach ($randomProjects as $project) {
                DB::table('student_project')->insert([
                    'student_id' => $student->id,
                    'project_id' => $project->id,
                    'justification' => 'I am interested in this project because of XYZ reason.'  
                ]);
            }
        }
    }
}
