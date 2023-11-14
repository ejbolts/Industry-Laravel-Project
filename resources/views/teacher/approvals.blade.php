@extends('layouts.master')
@section('title', 'Teacher Approvals')

@section('content')
<div class="container">
    <h1>Pendding Approvals of Industry Partners</h1>
    @if($industryPartners->isEmpty())
        <p>No pending approvals.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($industryPartners as $partner)
                <tr>
                    <td>{{ $partner->name }}</td>
                    <td>{{ $partner->email }}</td>
                    <td>
                        <form action="{{ route('teacher.approve', $partner->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        <form action="{{ route('teacher.reject', $partner->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a class="btn" href="{{url("IndustryPartner")}}">Home</a>


</div>
@endsection
