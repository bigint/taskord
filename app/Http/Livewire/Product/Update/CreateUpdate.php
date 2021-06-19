<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\Product;
use App\Notifications\Product\NewProductUpdate;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateUpdate extends Component
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
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:10000'],
        ]);

        $update = auth()->user()->productUpdates()->create([
            'user_id' => auth()->user()->id,
            'product_id' => $this->product->id,
            'title' => $this->title,
            'body' => $this->body,
        ]);
        $users = Product::find($this->product->id)->subscribers()->get();
        foreach ($users as $user) {
            $user->notify(new NewProductUpdate($update));
        }
        loggy(request(), 'Product', auth()->user(), "Created a new product update on #{$this->product->slug} | Update ID: {$update->id}");

        return redirect()->route('product.updates', ['slug' => $update->product->slug]);
    }
}
