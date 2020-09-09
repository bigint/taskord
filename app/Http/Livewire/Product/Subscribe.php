<?php

namespace App\Http\Livewire\Product;

use App\Notifications\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Please slow down!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('error', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->product->user->id) {
                return session()->flash('error', 'You can\'t subscribe your own product!');
            } else {
                Auth::user()->toggleSubscribe($this->product);
                $this->product->refresh();
                if (Auth::user()->hasSubscribed($this->product)) {
                    $this->product->user->notify(new Subscribed($this->product, Auth::id()));
                }
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
