<?php

namespace App\Http\Livewire;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskMentioned;
use App\Notifications\TelegramLogger;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTask extends Component
{
    use WithFileUploads;

    public $task;
    public $image;
    public $type;
    public $product_id;
    public $due_at;

    public function mount($type, $product_id)
    {
        $this->type = $type;
        $this->product_id = $product_id;
    }

    private function resetInputFields()
    {
        $this->task = '';
        $this->image = '';
    }

    public function getUserIDFromMention($string)
    {
        $mention = false;
        preg_match_all("/(@\w+)/u", $string, $matches);
        if ($matches) {
            $mentionsArray = array_count_values($matches[0]);
            $mention = array_keys($mentionsArray);
        }
        $usernames = str_replace('@', '', $mention);

        return $usernames;
    }

    public function checkState()
    {
        if (Auth::check()) {
            Auth::user()->checkState = ! Auth::user()->checkState;
            Auth::user()->save();
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updatedImage()
    {
        if (Auth::check()) {
            $this->validate([
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            $this->validate([
                'task' => 'required|min:5|max:10000',
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $users = $this->getUserIDFromMention($this->task);

            if ($this->image) {
                $image = $this->image->store('photos');
            } else {
                $image = null;
            }

            $state = Auth::user()->checkState;

            if ($state) {
                $done_at = Carbon::now();
            } else {
                $done_at = null;
            }

            $task = Task::create([
                'user_id' =>  Auth::id(),
                'product_id' =>  $this->product_id,
                'task' => $this->task,
                'done' => $state,
                'done_at' => $done_at,
                'image' => $image,
                'due_at' => $this->due_at,
                'type' => $this->type,
                'source' => 'Taskord for Web',
            ]);

            $this->emit('taskAdded');
            $this->resetInputFields();
            if ($users) {
                for ($i = 0; $i < count($users); $i++) {
                    $user = User::where('username', $users[$i])->first();
                    if ($user !== null) {
                        if ($user->id !== Auth::id()) {
                            $user->notify(new TaskMentioned($task));
                        }
                    }
                }
            }
            givePoint(new TaskCreated($task));
            Auth::user()->notify(
                new TelegramLogger(
                    '*✅ New Task* by @'
                    .Auth::user()->username."\n\n"
                    .$task->task."\n\nhttps://taskord.com/task/"
                    .$task->id
                )
            );

            return session()->flash('success', 'Task has been created!');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}
