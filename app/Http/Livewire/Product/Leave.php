<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Product\MemberLeft;

class Leave extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function leaveTeam()
    {
        if (Auth::check()) {
            Auth::user()->products()->detach($this->product);
            session()->flash('global', 'You are no longer member of the team!');
            $this->product->owner->notify(new MemberLeft($this->product, Auth::id()));

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }

    public function render()
    {
        return view('livewire.product.leave');
    }
}
