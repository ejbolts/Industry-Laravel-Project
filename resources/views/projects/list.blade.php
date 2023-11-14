@extends('layouts.master')
@section('title', 'Projects List')

@section('content')
<div class="container">
    @foreach ($projectsGroups as $year => $yearGroup)
        @foreach ($yearGroup as $trimester => $projects)
            <h2>Year: {{ $year }} | Trimester: {{ $trimester }}</h2>
            <ul>
                @foreach ($projects as $project)
                    <li><a href="{{ route('project.show', $project->id) }}">{{ $project->title }}</a></li>
                @endforeach
            </ul>
        @endforeach
    @endforeach


</div>
@endsection
