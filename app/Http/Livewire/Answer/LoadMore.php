<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public Question $question;
    public $page;
    public $perPage;
    public $loadMore;
    public $readyToLoad = true;

    public function mount($question, $page, $perPage)
    {
        $this->question = $question;
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
            $answers = Answer::whereQuestionId($this->question->id)
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->get();

            return view('livewire.answer.answers', [
                'answers' => $this->paginate($answers),
            ]);
        }

        return view('livewire.load-more');
    }
}
