<?php

namespace App\Http\Livewire\Product\Update;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use GrahamCampbell\Throttle\Facades\Throttle;

class SingleUpdate extends Component
{
    public $update;
    public $confirming;
    
    public function mount($update)
    {
        $this->update = $update;
    }
    
    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 50, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->update->user->id) {
                return session()->flash('error', 'You can\'t praise your own update!');
            }
            if (Auth::user()->hasLiked($this->update)) {
                Auth::user()->unlike($this->update);
                $this->update->refresh();
            } else {
                Auth::user()->like($this->update);
                $this->update->refresh();
                // TODO
                //$this->update->user->notify(new TaskPraised($this->update, Auth::id()));
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->update->id;
    }

    public function deleteUpdate()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->update->user->id) {
                $this->update->delete();
                $this->emitUp('updateDeleted');
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }
    
    public function render()
    {
        return view('livewire.product.update.single-update');
    }
}
