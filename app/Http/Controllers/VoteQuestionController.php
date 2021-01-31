<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        $votesCount = Auth::user()->voteTheQuestion($question, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                "message" => "Thanks for the feedback",
                "votesCount" => $votesCount
            ]);
        }
        return back();
    }
}
