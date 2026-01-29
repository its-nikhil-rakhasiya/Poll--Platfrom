@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Admin: Manage Poll #{{ $poll->id }}</h2>
        <p class="lead">{{ $poll->question }}</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>User</th>
                    <th>IP Address</th>
                    <th>Option Selected</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $vote)
                <tr>
                    <td>{{ $vote['created_at'] }}</td>
                    <td>{{ $vote['user_name'] ?? 'Guest' }}</td>
                    <td>{{ $vote['ip_address'] }}</td>
                    <td>{{ $vote['option_text'] }}</td>
                    <td>
                        @if($vote['status'] == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Released</span>
                            <br><small>at {{ $vote['released_at'] }}</small>
                        @endif
                    </td>
                    <td>
                        @if($vote['status'] == 'active')
                            <form method="POST" action="{{ route('polls.release', $poll->id) }}">
                                @csrf
                                <input type="hidden" name="ip_address" value="{{ $vote['ip_address'] }}">
                                <button type="submit" class="btn btn-warning btn-sm">Release IP</button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Released</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
        <a href="{{ route('polls.show', $poll->id) }}" class="btn btn-primary mt-3">Go to Poll</a>
    </div>
</div>
@endsection
