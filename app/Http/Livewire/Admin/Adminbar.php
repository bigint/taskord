<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Clean;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Adminbar extends Component
{
    protected $listeners = [
        'refreshStats' => 'render',
    ];

    public function refreshStats()
    {
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Refreshed Adminbar Status');

        $this->emitSelf('refreshStats');
    }

    public function clean()
    {
        Clean::dispatch()->delay(now()->addSeconds(10));
        activity()
            ->withProperties(['type' => 'Admin'])
            ->log('Cleaned the Application');

        return $this->alert('success', 'Cleaning process has been initiated successfully 🧼');
    }

    public function render()
    {
        if (file_exists('../.git/HEAD')) {
            $branch = File::get('../.git/HEAD');
            $explodedstring = explode('/', $branch, 3);
            $branchname = str_replace("\n", '', $explodedstring[2]);
        } else {
            $branchname = 'main';
        }

        if (file_exists('../.git/refs/heads/'.$branchname)) {
            $head = File::get('../.git/refs/heads/'.$branchname);
            $headHASH = $head;
        } else {
            $headHASH = '00000000';
        }

        // DB Details
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
        $jobs = Queue::size();

        return view('livewire.admin.adminbar', [
            'branchname' => $branchname,
            'headHASH' => $headHASH,
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
            'jobs' => number_format($jobs),
            'webhooks' => number_format($webhooks),
        ]);
    }
}
