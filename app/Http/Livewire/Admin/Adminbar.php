<?php

namespace App\Http\Livewire\Admin;

use App\Answer;
use App\AnswerPraise;
use App\Product;
use App\Question;
use App\QuestionPraise;
use App\Task;
use App\TaskComment;
use App\TaskCommentPraise;
use App\TaskPraise;
use App\User;
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
        $tasks = Task::cacheFor(60 * 60)->count();
        $users = User::cacheFor(60 * 60)->count();
        $products = Product::cacheFor(60 * 60)->count();
        $reputations = User::cacheFor(60 * 60)->sum('reputation');
        $questions = Question::cacheFor(60 * 60)->count();
        $answers = Answer::cacheFor(60 * 60)->count();
        $comments = TaskComment::cacheFor(60 * 60)->count();
        $praises =
            TaskPraise::count() +
            TaskCommentPraise::count() +
            QuestionPraise::count() +
            AnswerPraise::count();

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
