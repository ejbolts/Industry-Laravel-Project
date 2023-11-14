@extends('layouts.master')
@section('title')
    Create Project
@endsection
@section('content')

<div class="container">
    <form action="{{ route('project.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}">
        @error('title') 
            <span>{{ $message }}</span> 
        @enderror

        <label for="description">Description:</label>
        <textarea id="description" name="description">{{ old('description') }}</textarea>
        @error('description') 
            <span>{{ $message }}</span> 
        @enderror

        <label for="team_size">Team Size:</label>
        <input type="number" id="team_size" name="team_size" min="3" max="6" value="{{ old('team_size') }}">
        @error('team_size') 
            <span>{{ $message }}</span> 
        @enderror

    
        <label for="trimester">Trimester:</label>
        <select id="trimester" name="trimester">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        @error('trimester') 
            <span>{{ $message }}</span> 
        @enderror

            
        <label for="year">Year:</label>
        <select id="year" name="year">
            @for ($i = now()->year - 2; $i <= now()->year + 2; $i++)
                <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @error('year')
            <span>{{ $message }}</span>
        @enderror

        <input type="file" name="files[]" multiple>

        <button type="submit">Add Project</button>
    </form>
</div>
@endsection