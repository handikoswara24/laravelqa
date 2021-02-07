<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Question $question)
    {
        $question->favorites()->attach(Auth::id());


        return response()->json(null, 204);
    }

    public function destroy(Question $question)
    {
        $question->favorites()->detach(Auth::id());

        return response()->json(null, 204);
    }
}
