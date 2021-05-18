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
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
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

            $this->emit('answerAdded');
            $this->answer = '';
            Helper::mentionUsers($users, $answer, auth()->user(), 'answer');
            Helper::notifySubscribers($answer->question->subscribers, $answer, 'answer');
            if (! auth()->user()->hasSubscribed($answer->question)) {
                auth()->user()->subscribe($answer->question);
                $this->emit('questionSubscribed');
            }
            if (auth()->user()->id !== $this->question->user->id) {
                $this->question->user->notify(new Answered($answer));
                givePoint(new CommentCreated($answer));
            }
            loggy(request(), 'Answer', auth()->user(), 'Created a new answer | Answer ID: '.$answer->id);

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'success',
                'body' => 'Answer has been added!',
            ]);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
