@extends('layouts.bootstrap')

@section('content')
<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold text-body-emphasis mb-3">Poll Platform</h1>
    <p class="lead mb-4">Real-time Voting System</p>
    <div class="col-lg-6 mx-auto">
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            @auth
                <a href="{{ route('polls.index') }}" class="btn btn-primary btn-lg px-4 gap-3">View Polls</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Register</a>
            @endauth
        </div>
    </div>
</div>
@endsection
