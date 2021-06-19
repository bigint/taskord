<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\MemberLeft;
use Livewire\Component;

class Leave extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function leaveProduct()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        auth()->user()->products()->detach($this->product);
        $this->product->user->notify(new MemberLeft($this->product, auth()->user()->id));
        loggy(request(), 'Product', auth()->user(), "Left the team | Product ID: {$this->product->slug}");

        return redirect()->route('product.done', ['slug' => $this->product->slug]);
    }
}
