<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::where('status', 'active')->get();
        return view('polls.index', compact('polls'));
    }

    public function show($id)
    {
        $poll = Poll::with('options')->findOrFail($id);
        return view('polls.show', compact('poll'));
    }

    public function vote(Request $request)
    {
        $request->validate([
            'poll_id' => 'required|exists:polls,id',
            'option_id' => 'required|exists:poll_options,id',
        ]);

        $votingService = new \App\Services\CoreVotingLogic();
        $ip = $request->ip();
        
        // 1. Check if vote is allowed (Module 2)
        if (!$votingService->checkVoteAllowed($request->poll_id, $ip)) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already voted on this poll from this IP (' . $ip . ').'
            ], 403);
        }

        // 2. Cast Vote (Module 2)
        $userId = auth()->id(); // Can be null if we allow guests, but requirement says "Only authenticated"
        $votingService->castVote($request->poll_id, $request->option_id, $ip, $userId);

        return response()->json([
            'status' => 'success',
            'message' => 'Vote submitted successfully!'
        ]);
    }

    public function getResults($id)
    {
        $poll = Poll::with(['options' => function($query) {
            $query->withCount(['votes' => function($q) {
                $q->where('status', 'active');
            }]);
        }])->findOrFail($id);

        return response()->json($poll);
    }

    // Module 4: Admin View
    public function adminView($id)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $poll = Poll::findOrFail($id);
        $service = new \App\Services\CoreVotingLogic();
        $history = $service->getVoteHistory($id);

        return view('polls.admin', compact('poll', 'history'));
    }

    // Module 4: Release IP
    public function releaseIp(Request $request, $id)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $service = new \App\Services\CoreVotingLogic();
        $service->releaseIp($id, $request->ip_address);

        return back()->with('success', 'IP ' . $request->ip_address . ' released successfully.');
    }

    // Module 4: Main Admin Dashboard
    public function adminDashboard()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $polls = Poll::all();
        return view('admin.index', compact('polls'));
    }

    // Module 4 Extension: Create Poll Form
    public function create()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        return view('polls.create');
    }

    // Module 4 Extension: Store Poll
    public function store(Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = Poll::create([
            'question' => $request->question,
            'status' => 'active'
        ]);

        foreach ($request->options as $optionText) {
            \App\Models\PollOption::create([
                'poll_id' => $poll->id,
                'option_text' => $optionText
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Poll created successfully!');
    }
}
