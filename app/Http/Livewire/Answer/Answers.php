<?php

namespace App\Http\Livewire\Answer;

use App\Answer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Answers extends Component
{
    public $listeners = [
        'answerAdded' => 'render',
        'answerDeleted' => 'render',
    ];

    public $question;
    public $page;
    public $perPage;

    public function mount($question, $page, $perPage)
    {
        $this->question = $question;
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function paginate($items, $options = [])
    {
        $page = $this->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $this->perPage), $items->count(), $this->perPage, $page, $options);
    }

    public function render()
    {
        $answers = Answer::cacheFor(60 * 60)
            ->where('question_id', $this->question->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('livewire.answer.answers', [
            'answers' => $this->paginate($answers),
            'page' => $this->page,
        ]);
    }
}
