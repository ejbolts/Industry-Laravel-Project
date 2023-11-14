<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;  
use App\Models\Industry_Partner;  

class Project extends Model
{
    protected $fillable = [
        'industry_partner_id',
        'title',
        'description',
        'students_needed',
    ];

    public function industryPartner()
{
    return $this->belongsTo(Industry_Partner::class, 'industry_partner_id');
}


public function students()
{
    return $this->belongsToMany(Student::class, 'student_project')->withPivot('justification');
}
public function files()
{
    return $this->hasMany(ProjectFile::class);
}

    
}
