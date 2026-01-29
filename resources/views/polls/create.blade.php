@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">Create New Poll</div>
            <div class="card-body">
                <form method="POST" action="{{ route('polls.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="question" class="form-label">Poll Question</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Options</label>
                        <div id="options-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 1" required>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 2" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="addOptionBtn">Add Another Option</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Poll</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-link">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#addOptionBtn').click(function() {
        var input = '<div class="input-group mb-2"><input type="text" class="form-control" name="options[]" placeholder="New Option" required></div>';
        $('#options-container').append(input);
    });
});
</script>
@endpush
