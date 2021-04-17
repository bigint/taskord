<?php

namespace App\Http\Livewire\Admin;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Milestone;
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
        $tasks_done = Task::where('done', true)->count('id');
        $users = User::count('id');
        $users_active = User::whereDate('last_active', '>', carbon()->subDays(30))->count('id');
        $products = Product::count('id');
        $products_launched = Product::where('launched', true)->count('id');
        $reputations = User::sum('reputation');
        $questions = Question::count('id');
        $answers = Answer::count('id');
        $comments = Comment::count('id');
        $milestones = Milestone::count('id');
        $webhooks = Webhook::count('id');
        $notifications = DB::table('notifications')->count('id');
        $logs = Activity::count('id');
        $interactions = DB::table('interactions')->count();
        $praises = DB::table('interactions')->whereRelation('like')->count();

        return [
            'tasks' => number_format($tasks),
            'tasks_done' => number_format($tasks_done),
            'tasks_pending' => number_format($tasks - $tasks_done),
            'users' => number_format($users),
            'users_active' => number_format($users_active),
            'products' => number_format($products),
            'products_launched' => number_format($products_launched),
            'products_unlaunched' => number_format($products - $products_launched),
            'reputations' => number_format($reputations),
            'questions' => number_format($questions),
            'answers' => number_format($answers),
            'comments' => number_format($comments),
            'milestones' => number_format($milestones),
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
