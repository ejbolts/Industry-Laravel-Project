@extends('layouts.master')
@section('title')
    Industry Partner
@endsection
@section('content')
<div class="container">
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <h1>{{$industry_partner->name}}</h1>
    <p>Email: {{ $industry_partner->email }}</p>
    <label>Projects:</label>

    @foreach ($industry_partner->projects as $project)
    <ul>
        <li><a href="{{ url('Project/' . $project->id) }}">{{ $project->title }}</a></li>
    </ul>
    @endforeach

        <div style="display:flex">
            @auth
                @if (auth()->user()->industry_partner)
                    <form method="POST" action='{{url("IndustryPartner/$industry_partner->id")}}'>
                        {{csrf_field()}}
                        {{ method_field('DELETE') }}
                        <input class="btn-delete" style="margin-right: 10px" type="submit" value="Delete">
                    </form>
                @endif
            @endauth

        <a class="btn" href="{{url("IndustryPartner")}}">Home</a>
    </div>
</div>
@endsection