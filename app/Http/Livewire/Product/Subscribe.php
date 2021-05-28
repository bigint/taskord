<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while subscribing to a product');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (Gate::denies('praise', $this->product)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        auth()->user()->toggleSubscribe($this->product);
        $this->product->refresh();
        auth()->user()->touch();
        if (auth()->user()->hasSubscribed($this->product)) {
            $this->product->user->notify(new Subscribed($this->product, auth()->user()->id));
        }

        return loggy(request(), 'Product', auth()->user(), 'Toggled product subscribe | Product ID: #'.$this->product->slug);
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
