<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\ProductUpdate;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('praise', $this->update)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        if (auth()->user()->hasLiked($this->update)) {
            auth()->user()->unlike($this->update);
            $this->update->refresh();

            return auth()->user()->touch();
        }
        auth()->user()->like($this->update);
        $this->update->refresh();

        return auth()->user()->touch();
    }

    public function deleteUpdate()
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->update->user->id) {
            loggy(request(), 'Product', auth()->user(), 'Deleted a product update on #'.$this->update->product->slug.' | Update ID: '.$this->update->id);
            $this->update->delete();

            return $this->emitUp('refreshProduct');
        }

        return toast($this, 'error', "Oops! You can't perform this action");
    }
}
