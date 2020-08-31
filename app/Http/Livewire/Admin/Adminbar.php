<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;

class Adminbar extends Component
{
    protected $listeners = [
        'refreshStats' => 'render',
    ];

    public function refreshStats()
    {
        $this->emitSelf('refreshStats');
    }

    public function render()
    {
        if (file_exists('../.git/HEAD')) {
            $branch = File::get('../.git/HEAD');
            $explodedstring = explode('/', $branch, 3);
            $branchname = str_replace("\n", '', $explodedstring[2]);
        } else {
            $branchname = 'master';
        }
        if (file_exists('../VERSION')) {
            $version = File::get('../VERSION');
        } else {
            $version = '0.0.0';
        }

        // DB Details
        $tasks = Task::count('id');
        $users = User::count('id');
        $products = Product::count('id');
        $reputations = User::sum('reputation');
        $questions = Question::count('id');
        $answers = Answer::count('id');
        $comments = Comment::count('id');
        $praises = 20;
        $jobs = Queue::size();

        return view('livewire.admin.adminbar', [
            'version' => $version,
            'branchname' => $branchname,
            'tasks' => number_format($tasks),
            'users' => number_format($users),
            'products' => number_format($products),
            'reputations' => number_format($reputations),
            'questions' => number_format($questions),
            'answers' => number_format($answers),
            'comments' => number_format($comments),
            'praises' => number_format($praises),
            'jobs' => number_format($jobs),
        ]);
    }
}
