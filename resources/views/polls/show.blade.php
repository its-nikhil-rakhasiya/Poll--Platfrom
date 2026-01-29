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

                <div class="mt-4">
                    <h4>Live Results</h4>
                    <div id="results-container">
                        @foreach($poll->options as $option)
                            <div class="mb-2">
                                <span class="fw-bold">{{ $option->option_text }}</span>: <span id="count-{{ $option->id }}">0</span> votes
                                <div class="progress">
                                    <div id="bar-{{ $option->id }}" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const pollId = {{ $poll->id }};

    function fetchResults() {
        $.ajax({
            url: "/polls/" + pollId + "/results",
            type: "GET",
            success: function(data) {
                let totalVotes = 0;
                data.options.forEach(opt => {
                    totalVotes += opt.votes_count;
                });

                data.options.forEach(opt => {
                    let percentage = totalVotes > 0 ? ((opt.votes_count / totalVotes) * 100).toFixed(1) : 0;
                    $('#count-' + opt.id).text(opt.votes_count);
                    $('#bar-' + opt.id).css('width', percentage + '%').text(percentage + '%');
                });
            }
        });
    }

    // Poll every 1 second (Module 3)
    setInterval(fetchResults, 1000);
    fetchResults(); // Initial call

    $('#voteForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        
        $.ajax({
            url: "{{ route('polls.vote') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#message').html('<div class="alert alert-success">'+response.message+'</div>');
                $('#voteBtn').prop('disabled', true);
                fetchResults(); // Update immediately
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
