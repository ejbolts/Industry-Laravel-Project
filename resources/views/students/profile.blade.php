@extends('layouts.master')
@section('title')
    Profile
@endsection
@section('content')
<div class="container"> 
    <h2>{{ $student->name }}'s Profile</h2>
    <p>Email: {{ $student->email }}</p>
    <p>GPA: {{ $student->gpa }}</p>
    <p>Roles:</p>
    <ul>
        @foreach($student->roles as $role)
            <li>{{ $role->name }}</li>
        @endforeach
    </ul>

    @if($student->projects->isNotEmpty())
        <h3>Projects:</h3>
        <ul>
            @foreach($student->projects as $project)
                <li>{{ $project->title }} ({{ $project->year }}, Trimester {{ $project->trimester }})</li>
            @endforeach
        </ul>
    @else
        <p>No projects assigned.</p>
    @endif


    @if(auth()->id() === $student->user_id)
        <a href="{{ route('student.edit', $student) }}">Edit Profile</a>
    @endif
    <a class="btn" href="{{url("IndustryPartner")}}">Home</a>

</div>
@endsection
