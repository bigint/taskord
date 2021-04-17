<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Stats extends Component
{
    public $readyToLoad = false;

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function getStats()
    {
        $tasks = Task::count('id');
        $users = User::count('id');
        $products = Product::count('id');
        $reputations = User::sum('reputation');
        $questions = Question::count('id');
        $answers = Answer::count('id');
        $comments = Comment::count('id');
        $webhooks = Webhook::count('id');
        $notifications = DB::table('notifications')->count('id');
        $logs = Activity::count('id');
        $interactions = DB::table('interactions')->count();
        $praises = DB::table('interactions')->whereRelation('like')->count();

        return [
            'tasks' => number_format($tasks),
            'users' => number_format($users),
            'products' => number_format($products),
            'reputations' => number_format($reputations),
            'questions' => number_format($questions),
            'answers' => number_format($answers),
            'comments' => number_format($comments),
            'notifications' => number_format($notifications),
            'interactions' => number_format($interactions),
            'logs' => number_format($logs),
            'praises' => number_format($praises),
            'webhooks' => number_format($webhooks),
        ];
    }

    public function render()
    {
        return view('livewire.admin.stats', [
            'stats' => $this->readyToLoad ? $this->getStats() : [],
        ]);
    }
}
