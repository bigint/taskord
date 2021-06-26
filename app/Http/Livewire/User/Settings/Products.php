<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Product\MemberLeft;
use Illuminate\Contracts\View\View;
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

        $this->products = Product::with(['user'])
            ->whereUserId($this->user->id)
            ->orWhereHas('members', function (Builder $query) {
                $query->whereUserId($this->user->id);
            })->get();
    }

    public function leaveProduct(Product $product)
    {
        $product->members()->detach($this->user);
        $product->user->notify(new MemberLeft($product, $this->user->id));

        $this->user->touch();

        loggy(request(), 'Product', $this->user, "Left the team | Product ID: #{$product->id}");

        return toast($this, 'success', 'You are no longer member of the team!');
    }

    public function render(): View
    {
        return view('livewire.user.settings.products');
    }
}
