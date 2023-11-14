@extends('layouts.master')
@section('title')
    Edit Details
@endsection
@section('content')
<div class="container"> 
    <h2>Edit Profile</h2>
    <form action="{{ route('student.update', $student) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="gpa">GPA</label>
            <input type="number" step="0.01" min="0" max="7" name="gpa" id="gpa" value="{{ $student->gpa }}" required>

            <div class="mt-4" id="roles-section">
            <label>Roles:</label><br>
            
            <input type="checkbox" 
                id="software-developer" 
                name="roles[]" 
                value="software developer"
                @if($roles->contains('name', 'software developer')) checked @endif>
            <label for="software-developer">Software Developer</label><br>
            
            <input type="checkbox" 
                id="project-manager" 
                name="roles[]" 
                value="project manager"
                @if($roles->contains('name', 'project manager')) checked @endif>
            <label for="project-manager">Project Manager</label><br>
            
            <input type="checkbox" 
                id="business-analyst" 
                name="roles[]" 
                value="business analyst"
                @if($roles->contains('name', 'business analyst')) checked @endif>
            <label for="business-analyst">Business Analyst</label><br>
            
            <input type="checkbox" 
                id="tester" 
                name="roles[]" 
                value="tester"
                @if($roles->contains('name', 'tester')) checked @endif>
            <label for="tester">Tester</label><br>
            
            <input type="checkbox" 
                id="client-liaison" 
                name="roles[]" 
                value="client liaison"
                @if($roles->contains('name', 'client liaison')) checked @endif>
            <label for="client-liaison">Client Liaison</label><br>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
    <a href="javascript:history.back()" class="btn btn-primary">Go Back</a>

</div>
@endsection
