<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\Product;
use App\Notifications\Product\NewProductUpdate;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class NewUpdate extends Component
{
    public $title;
    public $body;
    public Product $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:10000'],
        ]);

        $update = auth()->user()->productUpdates()->create([
            'user_id' =>  auth()->user()->id,
            'product_id' => $this->product->id,
            'title' => $this->title, $this->body,
        ]);
        auth()->user()->touch();
        $users = Product::find($this->product->id)->subscribers()->get();
        foreach ($users as $user) {
            $user->notify(new NewProductUpdate($update));
        }
        loggy(request(), 'Product', auth()->user(), 'Created a new product update on #'.$this->product->slug.' | Update ID: '.$update->id);

        return redirect()->route('product.updates', ['slug' => $update->product->slug]);
    }
}
