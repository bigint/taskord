<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Questions extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $readyToLoad = false;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function loadQuestions()
    {
        $this->readyToLoad = true;
    }

    public function getQuestions()
    {
        if ($this->type === 'questions.newest') {
            return Question::with(['user', 'answers', 'answers.user'])
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.unanswered') {
            return Question::with(['user', 'answers', 'answers.user'])
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->doesntHave('answers')
                ->latest()
                ->get();
        } elseif ($this->type === 'questions.popular') {
            return Question::with(['user', 'answers', 'answers.user'])
                ->withCount('answers')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->has('answers')
                ->orderBy('answers_count', 'desc')
                ->get();
        }
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render(): View
    {
        return view('livewire.question.questions', [
            'questions' => $this->readyToLoad ? $this->paginate($this->getQuestions()) : [],
            'page' => $this->page,
        ]);
    }
}
