@extends('layouts.master')
@section('title')
    Project Details
@endsection
@section('content')
<div class="container">
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <h1>{{ $project->title }}</h1>
    <p>Description: {{ $project->description }}</p>
    <p>Students Needed: {{ $project->team_size }}</p> 
    <p>Offered By: <a href="{{ url('IndustryPartner/' . $project->industry_partner_id) }}">{{ $project->industryPartner->name }}</a></p>

    @foreach($project->files as $file)
        @if($file->file_type == 'image')
        <img src="{{ asset('/' . $file->file_path) }}" alt="Project Image" style="width:300px;height:300px;">
        @else
            <a href="{{ asset('/' . $file->file_path) }}" download>Download PDF</a><br>
        @endif
    @endforeach
    
    @auth
        @if(auth()->user()->student)
            <form action="{{ route('project.apply', $project->id) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="justification">Why do you want to work on this project?</label>
                    <textarea id="justification" name="justification" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Apply</button>
            </form>
        @endif
    @endauth
    
    <h3>Students Applied for this Project:</h3>
    @if ($project->students->count() > 0)
        <ul>
            @foreach ($project->students as $student)
            <p>Name: {{ $student->name }}</p>
           
            <p>Justification: {{ $student->pivot->justification }}</p>
            @endforeach
        </ul>
    @else
        <p>No students have applied for this project yet.</p>
    @endif

    @auth
        @if(auth()->user()->industry_partner && auth()->user()->industry_partner->id == $project->industry_partner_id)
            <form action="{{ url('project/'.$project->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif
    @endauth

    @auth
        @if(auth()->user()->industry_partner && auth()->user()->industry_partner->id == $project->industry_partner_id)
            <a href="{{ route('project.edit', $project->id) }}" class="btn btn-primary">Edit</a>
        @endif
    @endauth

    <a href="{{ url('IndustryPartner/' . $project->industry_partner_id) }}" class="btn btn-secondary">Back</a>
</div>
@endsection
