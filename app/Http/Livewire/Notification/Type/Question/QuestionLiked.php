<?php

namespace App\Http\Livewire\Notification\Type\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class QuestionLiked extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $question = Question::find($this->data['question_id']);

        return view('livewire.notification.type.question.question-liked', [
            'question' => $question,
        ]);
    }
}
