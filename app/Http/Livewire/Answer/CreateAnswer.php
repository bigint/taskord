<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\CommentCreated;
use App\Models\Question;
use App\Notifications\Answer\Answered;
use Helper;
use Livewire\Component;

class CreateAnswer extends Component
{
    public $answer;
    public Question $question;

    protected $rules = [
        'answer' => ['required', 'max:20000'],
    ];

    public function mount($question)
    {
        $this->question = $question;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate();

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $answer = auth()->user()->answers()->create([
            'question_id' =>  $this->question->id,
            'answer' => $this->answer,
        ]);
        auth()->user()->touch();
        $this->emit('refreshAnswers');

        $users = Helper::getUsernamesFromMentions($this->answer);

        if ($users) {
            $this->answer = Helper::parseUserMentionsToMarkdownLinks($this->answer, $users);
        }

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
        loggy(request(), 'Answer', auth()->user(), 'Created a new answer | Answer ID: '.$answer->id);

        return toast($this, 'success', 'Answer has been added!');
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
