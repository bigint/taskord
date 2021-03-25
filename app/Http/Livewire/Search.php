<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class Search extends Component
{
    public $query;
    public $tasks;
    public $users;
    public $products;
    public $questions;

    public function mount()
    {
        $this->query = '';
        $this->tasks;
        $this->users;
        $this->products;
        $this->questions;
    }

    public function updatedQuery()
    {
        $this->tasks = Task::select('id', 'task', 'done', 'hidden', 'user_id')
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                    ['isPrivate', false],
                ]);
            })
            ->where('hidden', false)
            ->search($this->query)
            ->take(3)
            ->get();
        $this->users = User::where('isFlagged', 'false')
            ->search($this->query)
            ->take(3)
            ->get();
        $this->products = Product::select('slug', 'name', 'avatar', 'user_id')
            ->search($this->query)
            ->take(3)
            ->get();
        $this->questions = Question::select('id', 'title', 'user_id')
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
            ->where('hidden', false)
            ->search($this->query)
            ->take(3)
            ->get();
    }
}
