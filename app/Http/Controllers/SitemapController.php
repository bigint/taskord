<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;

class SitemapController extends Controller
{
    public function users()
    {
        $users = User::cacheFor(60 * 60)
            ->select('username')
            ->get();

        return view('seo.sitemap_users', [
            'users' => $users,
        ]);
    }

    public function products()
    {
        $products = Product::cacheFor(60 * 60)
            ->select('slug')
            ->get();

        return view('seo.sitemap_products', [
            'products' => $products,
        ]);
    }

    public function questions()
    {
        $questions = Question::cacheFor(60 * 60)
            ->select('id')
            ->get();

        return view('seo.sitemap_questions', [
            'questions' => $questions,
        ]);
    }

    public function tasks()
    {
        $tasks = Task::cacheFor(60 * 60)
            ->select('id', 'source', 'hidden')
            ->where([
                ['hidden', false],
                ['source', '!=', 'GitHub'],
                ['source', '!=', 'GitLab'],
            ])
            ->get();

        return view('seo.sitemap_tasks', [
            'tasks' => $tasks,
        ]);
    }

    public function comments()
    {
        $comments = Comment::cacheFor(60 * 60)
            ->select('id', 'task_id')
            ->get();

        return view('seo.sitemap_comments', [
            'comments' => $comments,
        ]);
    }
}
