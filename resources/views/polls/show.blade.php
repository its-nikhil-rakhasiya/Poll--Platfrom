@extends('layouts.bootstrap')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>{{ $poll->question }}</h3>
            </div>
            <div class="card-body">
                <form id="voteForm">
                    @csrf
                    <input type="hidden" name="poll_id" value="{{ $poll->id }}">
                    <div class="mb-3">
                        @foreach($poll->options as $option)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="option_id" id="option_{{ $option->id }}" value="{{ $option->id }}">
                                <label class="form-check-label" for="option_{{ $option->id }}">
                                    {{ $option->option_text }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary" id="voteBtn">Vote</button>
                </form>
                <div id="message" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#voteForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        
        $.ajax({
            url: "{{ route('polls.vote') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#message').html('<div class="alert alert-success">'+response.message+'</div>');
                // Hide form or disable?
                $('#voteBtn').prop('disabled', true);
            },
            error: function(xhr) {
                let errorMsg = 'An error occurred';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#message').html('<div class="alert alert-danger">'+errorMsg+'</div>');
            }
        });
    });
});
</script>
@endpush
@endsection
