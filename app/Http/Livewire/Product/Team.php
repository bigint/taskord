<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Product\MemberRemoved;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Team extends Component
{
    public Product $product;
    public User $user;

    public function mount($product, $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function removeMember()
    {
        if (Auth::check()) {
            $this->user->products()->detach($this->product);
            $this->user->notify(new MemberRemoved($this->product, Auth::id()));
            activity()
                ->withProperties(['type' => 'Product'])
                ->log('Product member was removed from the team P: #'.$this->product->slug.' U: @'.$this->user->username);

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }
}
