<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use App\Models\AnswerPraise;
use App\Models\Product;
use App\Models\Question;
use App\Models\QuestionPraise;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskCommentPraise;
use App\Models\User;
use Illuminate\Support\Facades\File;
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
        $tasks = Task::cacheFor(60 * 60)->count('id');
        $users = User::cacheFor(60 * 60)->count('id');
        $products = Product::cacheFor(60 * 60)->count('id');
        $reputations = User::cacheFor(60 * 60)->sum('reputation');
        $questions = Question::cacheFor(60 * 60)->count('id');
        $answers = Answer::cacheFor(60 * 60)->count('id');
        $comments = TaskComment::cacheFor(60 * 60)->count('id');
        // TODO
        $praises = 54;

        return view('livewire.admin.adminbar', [
            'version' => $version,
            'branchname' => $branchname,
            'tasks' => $tasks,
            'users' => $users,
            'products' => $products,
            'reputations' => $reputations,
            'questions' => $questions,
            'answers' => $answers,
            'comments' => $comments,
            'praises' => $praises,
        ]);
    }
}
