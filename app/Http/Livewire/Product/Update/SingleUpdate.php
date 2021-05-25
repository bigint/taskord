<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\ProductUpdate;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleUpdate extends Component
{
    public ProductUpdate $update;

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
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the update');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }
        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->update->user->id) {
            return toast($this, 'error', 'You can\'t praise your own update!');
        }
        if (auth()->user()->hasLiked($this->update)) {
            auth()->user()->unlike($this->update);
            $this->update->refresh();
            auth()->user()->touch();
        } else {
            auth()->user()->like($this->update);
            $this->update->refresh();
            auth()->user()->touch();
            // TODO
            //$this->update->user->notify(new TaskPraised($this->update, auth()->user()->id));
        }
    }

    public function deleteUpdate()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->update->user->id) {
            loggy(request(), 'Product', auth()->user(), 'Deleted a product update on #'.$this->update->product->slug.' | Update ID: '.$this->update->id);
            $this->update->delete();
            $this->emitUp('refreshProduct');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
