<?php

namespace App\Models;
use App\Models\Student;  

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    public function students()
{
    return $this->belongsToMany(Student::class, 'student_role');
}
}

