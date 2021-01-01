<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\ProductUpdate;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleUpdate extends Component
{
    public ProductUpdate $update;
    public $confirming;

    public function mount($update)
    {
        $this->update = $update;
    }

    // TODO
    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the update');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (user()->id === $this->update->user->id) {
                return $this->alert('warning', 'You can\'t praise your own update!');
            }
            if (user()->hasLiked($this->update)) {
                user()->unlike($this->update);
                $this->update->refresh();
                user()->touch();
            } else {
                user()->like($this->update);
                $this->update->refresh();
                user()->touch();
                // TODO
                //$this->update->user->notify(new TaskPraised($this->update, user()->id));
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->update->id;
    }

    public function deleteUpdate()
    {
        if (Auth::check()) {
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            if (user()->staffShip or user()->id === $this->update->user->id) {
                activity()
                    ->withProperties(['type' => 'Product'])
                    ->log('Deleted a product update on #'.$this->update->product->slug.' | Update ID: '.$this->update->id);
                $this->update->delete();
                $this->emit('updateDeleted');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
