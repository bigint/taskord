<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskMentioned;
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
    public $due_at;
    public $product;

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

            $task = Task::create([
                'user_id' =>  Auth::id(),
                'product_id' =>  $this->product,
                'task' => $this->task,
                'done' => false,
                'image' => $image,
                'due_at' => $this->due_at,
                'type' => $this->product ? 'product' : 'user',
                'source' => 'Taskord for Web',
            ]);

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

            $this->emit('taskAdded');
            $this->reset();
            givePoint(new TaskCreated($task));
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.tasks.create-task');
    }
}
