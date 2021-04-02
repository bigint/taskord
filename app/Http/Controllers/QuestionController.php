<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function newest()
    {
        return view('question.questions', [
            'type' => 'questions.newest',
        ]);
    }

    public function unanswered()
    {
        return view('question.questions', [
            'type' => 'questions.unanswered',
        ]);
    }

    public function popular()
    {
        return view('question.questions', [
            'type' => 'questions.popular',
        ]);
    }

    public function question($id)
    {
        $question = Question::where('id', $id)->firstOrFail();
        $response = [
            'type' => 'question.question',
            'question' => $question,
        ];

        if (
            Auth::check() && auth()->user()->id === $question->user->id or
            Auth::check() && auth()->user()->staffShip
        ) {
            views($question)->record();

            return view('question.question', $response);
        } elseif (Auth::check() && $question->patronOnly) {
            if (Auth::check() && ! auth()->user()->isPatron) {
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
