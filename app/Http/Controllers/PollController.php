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
        return response()->json(['message' => 'Vote submitted successfully (Module 2 wip)']);
    }
}
