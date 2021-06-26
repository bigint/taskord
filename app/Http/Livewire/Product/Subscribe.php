<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\Subscribed;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Subscribe extends Component
{
    use WithRateLimiting;

    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function subscribeProduct()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->product)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->toggleSubscribe($this->product);
        $this->product->refresh();
        if (auth()->user()->hasSubscribed($this->product)) {
            $this->product->user->notify(new Subscribed($this->product, auth()->user()->id));
        }

        return loggy(request(), 'Product', auth()->user(), "Toggled product subscribe | Product ID: {$this->product->id}");
    }

    public function render(): View
    {
        return view('livewire.product.subscribe');
    }
}
