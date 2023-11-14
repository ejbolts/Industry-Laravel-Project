@extends('layouts.master')

@section('title', 'Student Profile')

@section('content')
<div class="container">
    <h1>{{ $student->name }}</h1>
    <p>Email: {{ $student->email }}</p>
    <p>GPA: {{ $student->gpa }}</p>
    <p>Roles:</p>
    <ul>
        @foreach($student->roles as $role)
            <li>{{ $role->name }}</li>
        @endforeach
    </ul>

    <a href="javascript:history.back()" class="btn btn-primary">Go Back</a>
</div>
@endsection
