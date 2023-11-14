<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;  

class Teacher extends Model
{
    protected $table = 'teachers';

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

 
}