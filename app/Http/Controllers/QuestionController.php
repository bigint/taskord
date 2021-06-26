<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class QuestionController extends Controller
{
    public function newest(): View
    {
        return view('question.questions', [
            'type' => 'questions.newest',
        ]);
    }

    public function unanswered(): View
    {
        return view('question.questions', [
            'type' => 'questions.unanswered',
        ]);
    }

    public function popular(): View
    {
        return view('question.questions', [
            'type' => 'questions.popular',
        ]);
    }

    public function question($slug): View
    {
        $question = Question::where('slug', $slug)->firstOrFail();
        $response = [
            'type' => 'question.question',
            'question' => $question,
        ];

        if (
            auth()->check() && auth()->user()->id === $question->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            views($question)->record();

            return view('question.question', $response);
        }

        if (auth()->check() && $question->patron_only) {
            if (auth()->check() && ! auth()->user()->is_patron) {
                return redirect()->route('patron.home');
            }

            views($question)->record();

            return view('question.question', $response);
        }

        if ($question->user->spammy) {
            return abort(404);
        }

        if ($question->patron_only) {
            return redirect()->route('patron.home');
        }

        return view('question.question', $response);
    }

    public function edit($slug): View
    {
        $question = Question::where('slug', $slug)->firstOrFail();

        if (
            auth()->check() && auth()->user()->id === $question->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('question.edit', [
                'question' => $question,
            ]);
        }

        return abort(404);
    }
}
