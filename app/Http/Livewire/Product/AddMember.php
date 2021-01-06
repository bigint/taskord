<?php

namespace App\Http\Livewire\Product;

use App\Models\User;
use App\Notifications\Product\MemberAdded;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $user = User::where('username', $this->username)->first();
            if ($user === null) {
                return $this->alert('error', 'User does not exists');
            }
            if ($user->products->contains($this->product) or $user->id === $this->product->owner->id) {
                return $this->alert('error', 'User is already in the team');
            }
            if (auth()->user()->username === $this->username) {
                return $this->alert('error', 'You can\'t add yourself to the team!');
            }
            $user->products()->attach($this->product);
            $user->notify(new MemberAdded($this->product, auth()->user()->id));
            loggy('Product', auth()->user(), 'Added @'.$user->username.' to #'.$this->product->slug);
            $this->flash('success', 'User has been added to the team!');

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }
}
