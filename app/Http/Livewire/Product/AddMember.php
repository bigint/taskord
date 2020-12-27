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
                return $this->alert('error', 'User does not exists', [
                    'showCancelButton' =>  false,
              ]);
            }
            if ($user->products->contains($this->product) or $user->id === $this->product->owner->id) {
                return $this->alert('error', 'User is already in the team', [
                    'showCancelButton' =>  false,
              ]);
            }
            if (Auth::user()->username === $this->username) {
                return $this->alert('error', 'You can\'t add yourself to the team!', [
                    'showCancelButton' =>  false,
              ]);
            }
            $user->products()->attach($this->product);
            $this->alert('success', 'User has been added to the team!', [
                'showCancelButton' =>  false,
          ]);
            $user->notify(new MemberAdded($this->product, Auth::id()));
            activity()
                ->withProperties(['type' => 'Product'])
                ->log('New member was added to the team P: #'.$this->product->slug.' U: @'.$user->username);
            $this->username = '';

            return $this->alert('success', 'User has been added to the team!', [
                'showCancelButton' =>  false,
          ]);
        }
    }
}
