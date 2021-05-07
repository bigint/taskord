<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Milestone;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;

class PagesController extends Controller
{
    public function deals()
    {
        $deals = Deal::latest()->get();

        return view('pages.deals', [
            'deals' => $deals,
        ]);
    }

    public function about()
    {
        $tasks = Task::count('id');
        $users = User::count('id');
        $questions = Question::count('id');
        $milestones = Milestone::count('id');

        return view('pages.about', [
            'tasks' => number_format($tasks),
            'users' => number_format($users),
            'questions' => number_format($questions),
            'milestones' => number_format($milestones),
        ]);
    }
}
