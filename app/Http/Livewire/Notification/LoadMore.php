<?php

namespace App\Http\Livewire\Notification;

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

    public function mount($page = 1, $perPage = 1)
    {
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
            if ($this->type === 'unread') {
                return view('livewire.notification.unread', [
                    'notifications' => $this->paginate(auth()->user()->unreadNotifications),
                ]);
            }

            return view('livewire.notification.all', [
                'notifications' => $this->paginate(auth()->user()->notifications),
            ]);
        }

        return view('livewire.load-more');
    }
}
