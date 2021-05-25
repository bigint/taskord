<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Questions extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $ready_to_load = false;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadQuestions()
    {
        $this->ready_to_load = true;
    }

    public function getQuestions()
    {
        if ($this->type === 'questions.newest') {
            return Question::whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.unanswered') {
            return Question::whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
                ->doesntHave('answer')
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.popular') {
            return Question::withCount('answer')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->has('answer')
                ->orderBy('answer_count', 'desc')
                ->get();
        }
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        return view('livewire.question.questions', [
            'questions' => $this->ready_to_load ? $this->paginate($this->getQuestions()) : [],
            'page' => $this->page,
        ]);
    }
}
