<?php

namespace App\Http\Livewire;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskMentioned;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTask extends Component
{
    use WithFileUploads;

    public $task;
    public $image;
    public $type;
    public $product_id;

    public function mount($type, $product_id)
    {
        $this->type = $type;
        $this->product_id = $product_id;
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

    public function search($array, $key, $value)
    {
        $results = [];

        if (is_array($array)) {
            if (isset($array[$key]) && strtolower($array[$key]) == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
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
        if (Auth::check()) {
            $validatedData = $this->validate([
                'task' => 'required|min:5|max:10000|profanity',
                'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ],
            [
                'task.profanity' => 'Please check your words!',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $check_time = Auth::user()->tasks()
                ->select('task', 'created_at')
                ->where('created_at', '>', Carbon::now()->subMinutes(3)->toDateTimeString())
                ->latest()->get()->toArray();
            if (count($this->search($check_time, 'task', strtolower($this->task))) > 0) {
                return session()->flash('error', 'Your already posted this task, wait for sometime!');
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
                'type' => $this->type,
            ]);

            $this->emit('taskAdded');
            $this->reset();
            if ($users) {
                $ids = [];
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
