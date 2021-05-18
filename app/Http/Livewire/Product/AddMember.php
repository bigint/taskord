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
        if (auth()->check()) {
            $user = User::whereUsername($this->username)->first();
            if ($user === null) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'User does not exists',
                ]);
            }
            if ($user->products->contains($this->product) or $user->id === $this->product->owner->id) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'User is already in the team',
                ]);
            }
            if (auth()->user()->username === $this->username) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'You can\'t add yourself to the team!',
                ]);
            }
            $user->products()->attach($this->product);
            $user->notify(new MemberAdded($this->product, auth()->user()->id));
            loggy(request(), 'Product', auth()->user(), 'Added @'.$user->username.' to #'.$this->product->slug);

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }
}
