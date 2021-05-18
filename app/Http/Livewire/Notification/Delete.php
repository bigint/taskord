<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;

class Delete extends Component
{
    public function deleteAll()
    {
        if (auth()->check()) {
            auth()->user()->notifications()->delete();
            $this->emit('deleteAll');
            auth()->user()->touch();
            loggy(request(), 'Notification', auth()->user(), 'Deleted all notifications');

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'success',
                'body' => 'All notifications has been deleted!',
            ]);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
