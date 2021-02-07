<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        $votesCount = Auth::user()->voteTheQuestion($question, $vote);

        return response()->json([
            "message" => "Thanks for the feedback",
            "votesCount" => $votesCount
        ]);
    }
}
