<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Question;

class SearchController extends Controller
{
    public function search()
    {
        return view('search.search');
    }

    public function tasks(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $tasks = Task::cacheFor(60 * 60)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->where('task', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($tasks) === 0) {
                $tasks = null;
            }
        } else {
            return redirect()->route('search.home');
        }
        

        return view('search.tasks', [
            'tasks' =>  $tasks,
        ]);
    }
    
    public function comments(Request $request)
    {
        
    }
    
    public function questions(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $questions = Question::cacheFor(60 * 60)
                ->select('id', 'title', 'user_id')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                    ]);
                })
                ->where('title', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($questions) === 0) {
                $questions = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.questions', [
            'questions' =>  $questions,
        ]);
    }
    
    public function answers(Request $request)
    {
        
    }
    
    public function users(Request $request)
    {
        
    }
}
