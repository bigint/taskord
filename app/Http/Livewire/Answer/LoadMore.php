<?php

namespace App\Http\Livewire\Answer;

use App\Answer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class LoadMore extends Component
{
    public $question;
    public $page;
    public $perPage;
    public $loadMore;

    public function mount($question, $page, $perPage)
    {
        $this->question = $question;
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
            $answers = Answer::cacheFor(60 * 60)
                ->where('question_id', $this->question->id)
                ->get();

            return view('livewire.answer.answers', [
                'answers' => $this->paginate($answers),
            ]);
        } else {
            return view('livewire.load-more');
        }
    }
}
