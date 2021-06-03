<?php

namespace App\Http\Livewire\Notification\Type\Answer;

use App\Models\Answer;
use Livewire\Component;

class AnswerLiked extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $answer = Answer::find($this->data['answer_id']);

        return view('livewire.notification.type.answer.answer-liked', [
            'answer' => $answer,
        ]);
    }
}
