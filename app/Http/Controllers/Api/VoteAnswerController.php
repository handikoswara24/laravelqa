<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $vote = (int) request()->vote;
        $votesCount = Auth::user()->voteTheAnswer($answer, $vote);

        return response()->json([
            'message' => "Thanks for the feedback.",
            'votesCount' => $votesCount
        ]);
    }
}
