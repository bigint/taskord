<?php

namespace App\Http\Livewire\Notification;

use Auth;
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

    public function mount($type, $page = 1, $perPage = 1)
    {
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
            if ($this->type === 'unread') {
                return view('livewire.notification.notifications', [
                    'notifications' => $this->paginate(Auth::user()->notifications),
                ]);
            } else {
                return view('livewire.notification.all', [
                    'notifications' => $this->paginate(Auth::user()->notifications),
                ]);
            }
        } else {
            return view('livewire.load-more');
        }
    }
}
