<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Role;

class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('auth',['except'=>['showProfile']]);
        }

        public function showProfile($id)
        {
            $student = Student::with('projects')->findOrFail($id);
            return view('students.profile', compact('student'));
        }

    public function editProfile($id)
    {
        $student = Student::findOrFail($id);
        // Fetch the roles associated with the student
        $roles = $student->roles;
        return view('students.edit', compact('student', 'roles'));
    }
    
    public function updateProfile(Request $request, $id)
    {
        $student = Student::findOrFail($id);
    
        // Validate the request
        $request->validate([
            'gpa' => 'required|numeric|min:0|max:7',
            'roles' => 'array|max:3',
            'roles.*' => 'string|distinct' 
        ]);
        // If validation passes, save the student's data.
        $student->gpa = $request->gpa;
    
        // Synchronise the roles
        $roles = Role::whereIn('name', $request['roles'] ?? [])->get();
        $student->roles()->sync($roles);
        $student->save();
        return redirect()->route('student.profile', $student)->with('success', 'Profile updated successfully.');
    }
    
}
