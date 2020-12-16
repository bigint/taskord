<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function newest()
    {
        $trending = Question::cacheFor(60 * 60)
            ->orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('question.newest', [
            'type' => 'questions.newest',
            'trending' => $trending,
        ]);
    }

    public function unanswered()
    {
        $trending = Question::cacheFor(60 * 60)
            ->orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('question.unanswered', [
            'type' => 'questions.unanswered',
            'trending' => $trending,
        ]);
    }

    public function popular()
    {
        $trending = Question::cacheFor(60 * 60)
            ->orderByViews()
            ->has('answer')
            ->take(5)
            ->get()
            ->sortByDesc(function ($question) {
                return $question->answer->count('id');
            });

        return view('question.popular', [
            'type' => 'questions.popular',
            'trending' => $trending,
        ]);
    }

    public function question($id)
    {
        $question = Question::cacheFor(60 * 60)->where('id', $id)->firstOrFail();
        $response = [
            'type' => 'question.question',
            'question' => $question,
        ];

        if (
            Auth::check() && Auth::id() === $question->user->id or
            Auth::check() && Auth::user()->staffShip
        ) {
            views($question)->record();

            return view('question.question', $response);
        } elseif (Auth::check() && $question->patronOnly) {
            if (Auth::check() && ! Auth::user()->isPatron) {
                return redirect()->route('patron.home');
            } else {
                views($question)->record();

                return view('question.question', $response);
            }
        } elseif ($question->user->isFlagged) {
            return view('errors.404');
        }

        if ($question->patronOnly) {
            return redirect()->route('patron.home');
        } else {
            return view('question.question', $response);
        }
    }
}
