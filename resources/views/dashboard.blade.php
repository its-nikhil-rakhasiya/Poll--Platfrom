@extends('layouts.bootstrap')

@section('content')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <h5 class="card-title">You are logged in!</h5>
                <p class="card-text">Welcome to the Poll Platform.</p>
                <a href="{{ route('polls.index') }}" class="btn btn-primary">Go to Polls</a>
            </div>
        </div>
    </div>
</div>
@endsection
