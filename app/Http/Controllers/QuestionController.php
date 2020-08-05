<?php

namespace App\Http\Controllers;

use App\Question;
use Auth;

class QuestionController extends Controller
{
    public function newest()
    {
        $trending = Question::orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count();
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
                return $question->answer->count();
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
                return $question->answer->count();
            });

        return view('questions.popular', [
            'type' => 'questions.popular',
            'trending' => $trending,
        ]);
    }

    public function question($id)
    {
        $question = Question::where('id', $id)->firstOrFail();
        views($question)->record();

        return view('question.question', [
            'type' => 'question.question',
            'question' => $question,
        ]);
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
