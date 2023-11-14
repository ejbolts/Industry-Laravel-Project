@extends('layouts.master')
@section('title')
    Home Page
@endsection
@section('content')
<div class="container">
    <h1>Home Page</h1>
    <ul >
        @foreach ($industry_partners as $industry_partner)
            <a href="IndustryPartner/{{$industry_partner->id}}"><li>{{ $industry_partner->name }}</li></a>
        @endforeach
    </ul>
    @auth
        @if (auth()->user()->industry_partner)
                <a class="btn" href="{{ url('IndustryPartner/create') }}">Add Project</a>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
        @endif
    @endauth
    
    @if (Auth::check() && Auth::user()->teacher) 
    <a class="btn" href="{{ route('teacher.students') }}">View All Students</a>
    <a class="btn" href="{{ route('teacher.approvals') }}">Industry Partner Approvals</a>
    @endif
    
    <a href="{{ url('/projectsList') }}" class="btn btn-primary">View Projects List</a>

    {{ $industry_partners->links() }} 
</div>
@endsection

