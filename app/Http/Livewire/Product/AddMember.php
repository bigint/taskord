<?php

namespace App\Http\Livewire\Product;

use App\Models\User;
use App\Notifications\Product\MemberAdded;
use Livewire\Component;

class AddMember extends Component
{
    public $product;
    public $username;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        $user = User::whereUsername($this->username)->first();
        if ($user === null) {
            return toast($this, 'error', 'User does not exists');
        }
        if ($user->products->contains($this->product) or $user->id === $this->product->user->id) {
            return toast($this, 'error', 'User is already in the team');
        }
        if (auth()->user()->username === $this->username) {
            return toast($this, 'error', 'You can\'t add yourself to the team!');
        }
        $user->products()->attach($this->product);
        $user->notify(new MemberAdded($this->product, auth()->user()->id));
        loggy(request(), 'Product', auth()->user(), 'Added @'.$user->username.' to #'.$this->product->slug);

        return redirect()->route('product.done', ['slug' => $this->product->slug]);
    }
}
