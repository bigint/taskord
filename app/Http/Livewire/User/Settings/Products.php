<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Product\MemberLeft;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Products extends Component
{
    public User $user;

    public Collection $products;

    public function mount($user)
    {
        $this->user = $user;

        $this->products = Product::where('user_id', $this->user->id)
            ->orWhereHas('members', function (Builder $query) {
                $query->where('user_id', $this->user->id);
            })->get();
    }

    public function render()
    {
        return view('livewire.user.settings.products');
    }

    public function leaveProduct(Product $product)
    {
        $product->members()->detach($this->user);
        $product->owner->notify(new MemberLeft($product, $this->user->id));

        $this->user->touch();

        loggy(request()->ip(), 'Product', $this->user, 'Left the team #'.$product->slug);

        return $this->alert('success', 'You are no longer member of the team!');
    }
}
