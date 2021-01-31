<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;
        $votesCount = Auth::user()->voteTheAnswer($answer, $vote);

        if (request()->expectsJson()) {
            return response()->json([
                'message' => "Thanks for the feedback.",
                'votesCount' => $votesCount
            ]);
        }
        return back();
    }
}
