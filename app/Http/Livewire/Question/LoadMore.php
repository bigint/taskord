<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $type;
    public $page;
    public $perPage;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page + 1;
        $this->perPage = $perPage;
        $this->loadMore = false;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render(): View
    {
        if ($this->loadMore) {
            if ($this->type === 'questions.newest') {
                $questions = Question::with(['user', 'answers', 'answers.user'])
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['spammy', false],
                        ]);
                    })
                    ->latest()
                    ->get();
            } elseif ($this->type === 'questions.unanswered') {
                $questions = Question::with(['user', 'answers', 'answers.user'])
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['spammy', false],
                        ]);
                    })
                    ->doesntHave('answers')
                    ->latest()
                    ->get();
            } elseif ($this->type === 'questions.popular') {
                $questions = Question::with(['user', 'answers', 'answers.user'])
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

            return view('livewire.question.questions', [
                'questions' => $this->paginate($questions),
            ]);
        }

        return view('livewire.load-more');
    }
}
