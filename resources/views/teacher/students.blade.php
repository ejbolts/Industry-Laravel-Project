@extends('layouts.master')

@section('title', 'Students List')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert-success" style="color: #1cdf46;">
            {{ session('success') }}
        </div>
    @endif
        <h1>All Students</h1>
        <ul>
            @foreach($students as $student)
                <li>
                    <a href="{{ route('student.profile', $student->id) }}">
                        {{ $student->name }}
                    </a>
                </li>
            @endforeach
        </ul>
        @if(auth()->user()->teacher) 
            <a href="{{ route('auto.assign') }}" class="btn btn-primary">Auto Assign Students</a>
        @endif
    <a class="btn" href="{{url("IndustryPartner")}}">Home</a>
</div>
@endsection
