<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry_Partner;
use App\Models\Student;

class TeacherController extends Controller
{
    // Constructor: Apply the authentication middleware to all methods in the controller.
    public function __construct() {
        $this->middleware('auth');
    }

    // Display all the Industry Partners who are waiting for approval.
    public function showApprovals() {
        $industryPartners = Industry_Partner::where('is_approved', false)->get();
        return view('teacher.approvals', compact('industryPartners'));
    }
    
    // Approve an Industry Partner.
    public function approve($id) {
        $industryPartner = Industry_Partner::findOrFail($id);
        $industryPartner->is_approved = true;
        $industryPartner->save();
        return redirect()->route('teacher.approvals')->with('success', 'Industry Partner approved successfully.');
    }

    // Reject an Industry Partner.
    public function reject($id) {
        $industryPartner = Industry_Partner::findOrFail($id);
        $industryPartner->is_approved = false;
        $industryPartner->save();
        return redirect()->route('teacher.approvals')->with('error', 'Industry Partner rejected.');
    }

    // Display a list of all students.
    public function students() {
        $students = Student::all();
        return view('teacher.students', compact('students'));
    }

    // Display the profile of a specific student.
    public function studentProfile($id) {
        $student = Student::find($id);
        if(!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        return view('teacher.studentProfile', compact('student'));
    }
}



