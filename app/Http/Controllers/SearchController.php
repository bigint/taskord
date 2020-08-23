<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

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

        return view('search.result', [
            'type' => 'tasks',
            'tasks' =>  $tasks,
        ]);
    }

    public function comments(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $comments = Comment::cacheFor(60 * 60)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['isFlagged', false],
                        ['isPrivate', false],
                    ]);
                })
                ->where('comment', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($comments) === 0) {
                $comments = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'comments',
            'comments' =>  $comments,
        ]);
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

        return view('search.result', [
            'type' => 'questions',
            'questions' =>  $questions,
        ]);
    }

    public function answers(Request $request)
    {
    }

    public function products(Request $request)
    {
    }

    public function users(Request $request)
    {
    }
}
