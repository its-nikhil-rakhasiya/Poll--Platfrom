@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4">Active Polls</h1>
        <div class="list-group">
            @forelse($polls as $poll)
                <a href="{{ route('polls.show', $poll->id) }}" class="list-group-item list-group-item-action">
                    {{ $poll->question }}
                </a>
            @empty
                <div class="alert alert-info">No active polls found.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
