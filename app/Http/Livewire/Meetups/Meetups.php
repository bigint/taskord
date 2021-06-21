<?php

namespace App\Http\Livewire\Meetups;

use App\Models\Meetup;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class Meetups extends Component
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

    public function loadMeetups()
    {
        $this->readyToLoad = true;
    }

    public function getMeetups()
    {
        if ($this->type === 'meetups.upcoming') {
            return Meetup::with('user')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                        ['is_private', false],
                    ]);
                })
                ->latest()
                ->get();
        } elseif ($this->type === 'meetups.finished') {
            return Meetup::whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                    ['is_private', false],
                ]);
            })
                ->latest()
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
        return view('livewire.meetups.meetups', [
            'meetups' => $this->readyToLoad ? $this->paginate($this->getMeetups()) : [],
            'page' => $this->page,
        ]);
    }
}
