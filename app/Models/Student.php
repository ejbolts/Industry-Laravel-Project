<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;  
use App\Models\Role;  


class Student extends Model
{
    protected $table = 'students';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'name',
        'email',
    ];
    

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
{
    return $this->belongsToMany(Project::class, 'student_project')->withPivot('justification');
}


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'student_role');
    }
    
   
}