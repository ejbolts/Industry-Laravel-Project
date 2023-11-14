<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Role;
use DB;

class StudentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        $roles = Role::all();

        foreach ($students as $student) {
            // Shuffle the roles and pick first 3 for each student
            $selectedRoles = $roles->shuffle()->take(3);
            
            foreach ($selectedRoles as $role) {
                DB::table('student_role')->insert([
                    'student_id' => $student->id,
                    'role_id' => $role->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
