<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function newest()
    {
        $trending = Question::orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('questions.newest', [
            'type' => 'questions.newest',
            'trending' => $trending,
        ]);
    }

    public function unanswered()
    {
        $trending = Question::orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('questions.unanswered', [
            'type' => 'questions.unanswered',
            'trending' => $trending,
        ]);
    }

    public function popular()
    {
        $trending = Question::orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('questions.popular', [
            'type' => 'questions.popular',
            'trending' => $trending,
        ]);
    }

    public function question($id)
    {
        $question = Question::where('id', $id)->firstOrFail();
        $response = [
            'type' => 'question.question',
            'question' => $question,
        ];

        if (Auth::check() && Auth::id() === $question->user->id or Auth::check() && Auth::user()->staffShip) {
            views($question)->record();

            return view('question.question', $response);
        } elseif ($question->user->isFlagged) {
            return view('errors.404');
        }

        return view('question.question', $response);
    }

    public function new()
    {
        return view('question.new');
    }

    public function edit($id)
    {
        $question = Question::where('id', $id)->firstOrFail();

        if (Auth::user()->staffShip or Auth::id() === $question->user_id) {
            return view('question.edit', [
                'question' => $question,
            ]);
        } else {
            return redirect()->route('question.question', [
                'id' => $question->id,
            ]);
        }
    }
}
