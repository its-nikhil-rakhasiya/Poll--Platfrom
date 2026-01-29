@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Active Polls</h2>
        
        <div class="list-group shadow-sm">
            @forelse($polls as $poll)
                <a href="{{ route('polls.show', $poll->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                    {{ $poll->question }}
                    <span class="badge bg-primary rounded-pill">Vote</span>
                </a>
            @empty
                <div class="alert alert-info">No active polls available at the moment.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
