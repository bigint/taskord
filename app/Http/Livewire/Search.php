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
        $this->tasks = Task::select('id', 'task', 'done', 'user_id')
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                    ['isPrivate', false],
                ]);
            })
            ->where('task', 'LIKE', '%'.$this->query.'%')
            ->take(3)
            ->get();
        $this->users = User::select('username', 'firstname', 'lastname', 'avatar', 'isFlagged')
            ->where('username', 'LIKE', '%'.$this->query.'%')
            ->orWhere('firstname', 'LIKE', '%'.$this->query.'%')
            ->orWhere('lastname', 'LIKE', '%'.$this->query.'%')
            ->take(3)
            ->get();
        $this->products = Product::select('slug', 'name', 'avatar', 'user_id')
            ->where('slug', 'LIKE', '%'.$this->query.'%')
            ->orWhere('name', 'LIKE', '%'.$this->query.'%')
            ->take(3)
            ->get();
        $this->questions = Question::select('id', 'title', 'user_id')
            ->whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
            ->where('title', 'LIKE', '%'.$this->query.'%')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.search');
    }
}
