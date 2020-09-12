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
                return session()->flash('team-error', 'User does not exists');
            }
            if ($user->products->contains($this->product) or $user->id === $this->product->owner->id) {
                return session()->flash('team-error', 'User already in the team');
            }
            if (Auth::user()->username === $this->username) {
                return session()->flash('team-error', 'You can\'t add yourself to the team!');
            }
            $user->products()->sync($this->product);
            session()->flash('global', 'User has been added to the team!');
            $user->notify(new MemberAdded($this->product, Auth::id()));

            return redirect()->route('product.done', ['slug' => $this->product->slug]);
        }
    }

    public function render()
    {
        return view('livewire.product.add-member');
    }
}
