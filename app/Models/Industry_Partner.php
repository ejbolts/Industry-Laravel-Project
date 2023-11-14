<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;  
use App\Models\Project;  

class Industry_Partner extends Model
{
   
    protected $table = 'industry_partners';

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
        return $this->hasMany(Project::class, 'industry_partner_id');
    }

}