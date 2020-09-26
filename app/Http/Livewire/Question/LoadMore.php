<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
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

    public function mount($page, $perPage, $type)
    {
        $this->type = $type;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button
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

    public function render()
    {
        if ($this->loadMore) {
            if ($this->type === 'questions.newest') {
                $questions = Question::cacheFor(60 * 60)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                        ]);
                    })
                    ->latest()
                    ->get();
            } elseif ($this->type === 'questions.unanswered') {
                $questions = Question::cacheFor(60 * 60)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                        ]);
                    })
                    ->doesntHave('answer')
                    ->latest()
                    ->get();
            } elseif ($this->type === 'questions.popular') {
                $questions = Question::cacheFor(60 * 60)
                    ->whereHas('user', function ($q) {
                        $q->where([
                            ['isFlagged', false],
                        ]);
                    })
                    ->has('answer')
                    ->get()
                    ->sortByDesc(function ($question) {
                        return $question->answer->count('id');
                    });
            }

            return view('livewire.question.questions', [
                'questions' => $this->paginate($questions),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
