<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Notifications\Product\MemberLeft;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Leave extends Component
{
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function leaveTeam()
    {
        if (Auth::check()) {
            auth()->user()->products()->detach($this->product);
            $this->product->owner->notify(new MemberLeft($this->product, auth()->user()->id));
            auth()->user()->touch();
            loggy('Product', auth()->user(), 'Left the team #'.$this->product->slug);

            $this->flash('success', 'You are no longer member of the team!');

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }
}
