<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; 
use App\Models\Student; 
use App\Models\ProjectFile; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except'=>['index', 'show','projectsList']]);
        }

    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => [
                'required',
                'min:6',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('year', $request->year)
                                 ->where('trimester', $request->trimester);
                }),
            ],
            'description' => 'required|min:3',
            'team_size' => 'required|integer|min:3|max:6',
            'trimester' => 'required|integer|min:1|max:3',
            'year' => 'required|integer|min:2000|max:' . now()->year + 2,

        ]);

        $inp = auth()->user()->industry_partner;
        if(!$inp->is_approved) {
            return redirect()->back()->with('error', 'You need to be approved by the teacher to create a project.');
        }


        $project = new Project();

        $project->title = $request->title;
        $project->description = $request->description;
        $project->team_size = $request->team_size;
        $project->trimester = $request->trimester;
        $project->year = $request->year;
        $project->industry_partner_id = auth()->user()->industry_partner->id;
        $project->save();
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = $file->store('projects_images', 'public'); 
                $fileType = $file->extension() === 'pdf' ? 'pdf' : 'image';
                $project->files()->create([
                    'file_path' => $filename,
                    'file_type' => $fileType,
                    'project_id' => $project->id 
                ]);
            }
        }
        return redirect('/'); 
    }

    public function show($id)
    {
        $project = Project::with('students')->findOrFail($id);
        return view('projects.detail', ['project' => $project]);
    }


    public function edit($id)
    {
        $project = Project::findOrFail($id);
        
        // Check if the project belongs to the authenticated industry partner
        if(auth()->user()->industry_partner && auth()->user()->industry_partner->id == $project->industry_partner_id) {
            return view('projects.edit', compact('project'));
        } else {
            return redirect()->back()->with('error', 'You are not authorised to edit this project.');
        }
    }

    public function projectsList() {
        $projects = Project::orderBy('year', 'desc')
                    ->orderBy('trimester', 'desc')
                    ->get()
                    ->groupBy(['year', 'trimester']);
        return view('projects.list', ['projectsGroups' => $projects]);
    }

    public function update(Request $request, $id)
{
    
    $project = Project::findOrFail($id);
    // Check if the project belongs to the authenticated industry partner
    if(auth()->user()->industry_partner && auth()->user()->industry_partner->id !== $project->industry_partner_id) {
        return redirect()->back()->with('error', 'You are not authorised to update this project.');
    }

    $validatedData = $request->validate([
        'title' => 'required|min:6',
        'description' => 'required|min:3',
    ]);

    // Update the project based on the validated data
    $project->update($validatedData);

  
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $filename = $file->store('projects_images', 'public'); 
            $fileType = $file->extension() === 'pdf' ? 'pdf' : 'image';
            $project->files()->create([
                'file_path' => $filename,
                'file_type' => $fileType,
            ]);
        }
    }

    // Redirect the user back to the project details page with a success message
    return redirect()->route('project.show', $project->id)->with('success', 'Project updated successfully!');
}

public function fileDelete($fileId)
{
    $file = ProjectFile::findOrFail($fileId);
    
    // Check if the authenticated user is the owner of the project related to the file
    $project = $file->project;
    if(auth()->user()->industry_partner->id !== $project->industry_partner_id) {
        return redirect()->back()->with('error', 'You can only delete files from your own projects.');
    }
    
    // Delete the file from the storage
    Storage::delete('public/' . $file->file_path);
    
    // Delete the file from the database
    $file->delete();
    
    return redirect()->back()->with('success', 'File deleted successfully!');
}



public function apply(Request $request, $id)
{
    $student = auth()->user()->student;

    // Check if the student has already applied for this project
    if ($student->projects()->where('project_id', $id)->exists()) {
        // Redirect back with an error message
        return redirect()->back()->with('error', 'You have already applied for this project.');
    }

    // Check the number of projects the student has already applied for
    $appliedProjectsCount = $student->projects()->count();

    if ($appliedProjectsCount >= 3) {
        // Redirect back with an error message
        return redirect()->back()->with('error', 'You have already applied for 3 projects.');
    }

    // If the student hasn't reached the limit and hasn't applied for this project, let them apply
    $student->projects()->attach($id, ['justification' => $request->justification]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Successfully applied for the project.');
}


    public function destroy($id)
    {
        $project = Project::find($id);

        // Check if the authenticated user is the owner of the project
        if(auth()->user()->industry_partner->id !== $project->industry_partner_id) {
            return redirect()->back()->with('error', 'You can only delete your own projects.');
        }

        // Check if there are students associated with the project
        if ($project->students()->count() > 0) {
            return redirect()->route('project.show', $id)
                ->with('error', 'Cannot delete project because there are students applied to work on this project.');
        }

        $project->delete();
        return redirect('/')->with('message', 'Project deleted successfully');
    }


// Auto-assign students to projects based on their roles and project requirements.
// assistance from chatGPT (see docs reference)
public function autoAssign() {
    // Retrieve all projects.
    $projects = Project::all();
    
    // Loop through each project to determine suitable students.
    foreach ($projects as $project) {
        // Retrieve students who have not yet been assigned to three projects.
        $studentsNotInThreeProjects = Student::whereHas('projects', function ($query) {
            $query->groupBy('student_project.student_id')
                  ->havingRaw('COUNT(student_project.project_id) < 3');
        })->orWhereDoesntHave('projects')->get();
        
        // Check each student for role conflicts with current project.
        foreach ($studentsNotInThreeProjects as $student) {
        $student_roles = $student->roles->pluck('id')->toArray();
        $conflict = false;
        // Loop through each role of the student to check for conflicts.
        foreach ($student_roles as $role_id) {
            // Check if there exists a conflict in the database:
            // Specifically, looking for a situation where another student
            // with the same role is already assigned to the current project.
            $exists = DB::table('student_project')
                        ->where('project_id', $project->id)
                        ->whereExists(function ($query) use ($role_id) {
                            // In this sub-query, trying to find out if another 
                            // student already assigned to the project has the same role.
                            $query->select(DB::raw(1))
                                ->from('student_role')
                                ->whereColumn('student_role.student_id', 'student_project.student_id')
                                ->where('student_role.role_id', $role_id);
                        })
                    ->exists();
                // If a conflict is found, skip current student.
                if ($exists) {
                    $conflict = true;
                    break;
                }
            }

            // If no conflicts, assign student to current project.
            if (!$conflict) {
                $project->students()->attach($student->id, ['justification' => 'Auto-assigned']);

                // Remove the assigned student from consideration for other projects.
                $studentsNotInThreeProjects = $studentsNotInThreeProjects->where('id', '!=', $student->id);

                // Move to the next project if the current one is filled.
                $current_assigned = $project->students()->count();
                if ($current_assigned >= $project->team_size) {
                    break;
                }
            } 
        }
    }

    // Return with a success message once all assignments are done.
    $message = 'Auto-assignment completed!';
    return redirect()->back()->with('success', $message);
}
}