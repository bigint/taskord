<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function newest()
    {
        return view('question.newest', [
            'type' => 'questions.newest',
        ]);
    }

    public function unanswered()
    {
        return view('question.unanswered', [
            'type' => 'questions.unanswered',
        ]);
    }

    public function popular()
    {
        return view('question.popular', [
            'type' => 'questions.popular',
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
            Auth::check() && user()->staffShip
        ) {
            views($question)->record();

            return view('question.question', $response);
        } elseif (Auth::check() && $question->patronOnly) {
            if (Auth::check() && ! user()->isPatron) {
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
