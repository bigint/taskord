<?php

namespace App\Http\Livewire\Product;

use App\Notifications\Product\MemberLeft;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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
            $this->alert('success', 'You are no longer member of the team!', [
                'showCancelButton' => true,
            ]);
            $this->product->owner->notify(new MemberLeft($this->product, Auth::id()));
            Auth::user()->touch();
            activity()
                ->withProperties(['type' => 'Product'])
                ->log('Product member left the team P: #'.$this->product->slug.'U: @'.Auth::user()->username);

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }

    public function render()
    {
        return view('livewire.product.leave');
    }
}
