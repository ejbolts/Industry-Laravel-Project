<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Role;
class StudentSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 3) as $index) {
            $user = User::create([
                'name' => "Student $index",
                'email' => "student$index@example.com",
                'password' => bcrypt('password'),
                'type' => 'student',
            ]);
        
            $student = Student::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'gpa' => rand(3, 7),
            ]);
        
            // Assign up to 3 random roles to student
            $roles = Role::inRandomOrder()->take(rand(1, 3))->get();
            $student->roles()->attach($roles);
        }
    }
}