<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\Subscribed;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
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

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Your are rate limited, try again later!',
            ]);
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }
            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }
            if (auth()->user()->id === $this->product->owner->id) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'You can\'t subscribe your own product!',
                ]);
            } else {
                auth()->user()->toggleSubscribe($this->product);
                $this->product->refresh();
                auth()->user()->touch();
                if (auth()->user()->hasSubscribed($this->product)) {
                    $this->product->owner->notify(new Subscribed($this->product, auth()->user()->id));
                }
                loggy(request(), 'Product', auth()->user(), 'Toggled product subscribe | Product ID: #'.$this->product->slug);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.product.subscribe');
    }
}
