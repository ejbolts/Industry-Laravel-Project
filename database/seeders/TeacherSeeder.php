<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Teacher John',
            'email' => 'teacherjohn@example.com',
            'password' => bcrypt('password123'),
            'type' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
