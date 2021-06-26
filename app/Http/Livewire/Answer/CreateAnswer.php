<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\CommentCreated;
use App\Models\Question;
use App\Notifications\Answer\Answered;
use Helper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateAnswer extends Component
{
    public $answer = '';
    public Question $question;

    protected $rules = [
        'answer' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($question)
    {
        $this->question = $question;
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();

        $users = Helper::getUsernamesFromMentions($this->answer);

        if ($users) {
            $this->answer = Helper::parseUserMentionsToMarkdownLinks($this->answer, $users);
        }

        $answer = auth()->user()->answers()->create([
            'question_id' => $this->question->id,
            'answer' => $this->answer,
        ]);
        $this->emit('refreshAnswers');

        $this->reset('answer');
        Helper::mentionUsers($users, $answer, auth()->user(), 'answer');
        Helper::notifySubscribers($answer->question->subscribers, $answer, 'answer');
        if (auth()->user()->id !== $this->question->user->id) {
            if (! auth()->user()->hasSubscribed($answer->question)) {
                auth()->user()->subscribe($answer->question);
                $this->emit('refreshQuestionSubscribe');
            }
            $this->question->user->notify(new Answered($answer));
            givePoint(new CommentCreated($answer));
        }
        loggy(request(), 'Answer', auth()->user(), "Created a new answer | Answer ID: {$answer->id}");

        return toast($this, 'success', 'Answer has been added!');
    }

    public function render(): View
    {
        return view('livewire.answer.create-answer');
    }
}
