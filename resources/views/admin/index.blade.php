@extends('layouts.bootstrap')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard</h2>
            <a href="{{ route('polls.create') }}" class="btn btn-success">Create New Poll</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="card mb-4">
            <div class="card-header">Manage Polls</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($polls as $poll)
                        <tr>
                            <td>{{ $poll->id }}</td>
                            <td>{{ $poll->question }}</td>
                            <td>
                                <span class="badge bg-{{ $poll->status == 'active' ? 'success' : 'secondary' }}">{{ $poll->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('polls.admin', $poll->id) }}" class="btn btn-primary btn-sm">Manage Votes</a>
                                <a href="{{ route('polls.show', $poll->id) }}" class="btn btn-info btn-sm">View Poll</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
