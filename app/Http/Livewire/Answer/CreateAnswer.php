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
        if (auth()->check()) {
            $this->validateOnly($field);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->answer);

            if ($users) {
                $this->answer = Helper::parseUserMentionsToMarkdownLinks($this->answer, $users);
            }

            $answer = auth()->user()->answers()->create([
                'question_id' =>  $this->question->id,
                'answer' => $this->answer,
            ]);
            auth()->user()->touch();

            $this->emit('refreshAnswers');
            $this->answer = '';
            Helper::mentionUsers($users, $answer, auth()->user(), 'answer');
            Helper::notifySubscribers($answer->question->subscribers, $answer, 'answer');
            if (! auth()->user()->hasSubscribed($answer->question)) {
                auth()->user()->subscribe($answer->question);
                $this->emit('refreshQuestionSubscribe');
            }
            if (auth()->user()->id !== $this->question->user->id) {
                $this->question->user->notify(new Answered($answer));
                givePoint(new CommentCreated($answer));
            }
            loggy(request(), 'Answer', auth()->user(), 'Created a new answer | Answer ID: '.$answer->id);

            return toast($this, 'success', 'Answer has been added!');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
