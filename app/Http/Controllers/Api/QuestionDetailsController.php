<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionDetailsResource;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Question $question, Question $question_slug)
    {
        if ($question->id == $question_slug->id) {
            $question->increment('views');

            return new QuestionDetailsResource($question_slug);
        } else {
            return response()->json([
                "message" => "Error"
            ], 400);
        }
    }
}
