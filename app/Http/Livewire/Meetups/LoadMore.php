<?php

namespace App\Http\Livewire\Meetups;

use App\Models\Meetup;
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

    public function render()
    {
        if ($this->loadMore) {
            if ($this->type === 'meetups.upcoming') {
                $meetups = Meetup::whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                        ['is_private', false],
                    ]);
                })
                    ->latest()
                    ->get();
            } elseif ($this->type === 'meetups.finished') {
                $meetups = Meetup::whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                        ['is_private', false],
                    ]);
                })
                    ->latest()
                    ->get();
            }

            return view('livewire.meetups.meetups', [
                'meetups' => $this->paginate($meetups),
            ]);
        }

        return view('livewire.load-more');
    }
}
