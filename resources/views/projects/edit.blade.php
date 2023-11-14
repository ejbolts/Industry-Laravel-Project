@extends('layouts.master')
@section('title')
    Project Edit Details
@endsection
@section('content')
<div class="container">
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ url('project/'.$project->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ old('title', $project->title) }}" class="form-control">
        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="description">Description:</label>
        <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <h3>Upload New Files</h3>
        <input type="file" name="files[]" multiple>

    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<h3>Existing Files</h3>
        @foreach($project->files as $file)
            <div>
                @if($file->file_type == 'image')
                    <img src="{{ asset('/' . $file->file_path) }}" alt="Project Image" style="width:100px;height:100px;">
                @else
                    <a href="{{ asset('/' . $file->file_path) }}" download>Download PDF</a>
                @endif
                
                <form method="POST" action="{{ route('project.fileDelete', $file->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
            </div>
        @endforeach

@endsection