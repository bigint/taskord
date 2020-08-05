<?php

namespace App\Http\Livewire;

use App\Product;
use App\Question;
use App\Task;
use App\User;
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
        $this->tasks = Task::cacheFor(60 * 60)
            ->where('task', 'LIKE', '%'.$this->query.'%')
            ->limit(3)
            ->get();
        $this->users = User::cacheFor(60 * 60)
            ->where('username', 'LIKE', '%'.$this->query.'%')
            ->orWhere('firstname', 'LIKE', '%'.$this->query.'%')
            ->orWhere('lastname', 'LIKE', '%'.$this->query.'%')
            ->limit(3)
            ->get();
        $this->products = Product::cacheFor(60 * 60)
            ->where('slug', 'LIKE', '%'.$this->query.'%')
            ->orWhere('name', 'LIKE', '%'.$this->query.'%')
            ->limit(3)
            ->get();
        $this->questions = Question::cacheFor(60 * 60)
            ->where('title', 'LIKE', '%'.$this->query.'%')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.search');
    }
}
