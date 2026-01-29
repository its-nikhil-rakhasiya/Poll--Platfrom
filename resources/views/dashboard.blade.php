@extends('layouts.bootstrap')

@section('content')
<div class="row mt-5">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm text-center">
            <div class="card-header bg-white">
                <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="card-body py-5">
                <h5 class="card-title mb-3">You are logged in!</h5>
                <p class="card-text text-muted mb-4">Welcome to the Poll Platform.</p>
                <a href="{{ route('polls.index') }}" class="btn btn-primary px-4 rounded-pill">Go to Polls</a>
            </div>
        </div>
    </div>
</div>
@endsection
