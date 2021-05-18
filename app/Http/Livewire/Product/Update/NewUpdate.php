<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\Product;
use App\Notifications\Product\NewProductUpdate;
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
        if (auth()->check()) {
            $this->validate([
                'title' => ['required', 'min:5', 'max:100'],
                'body' => ['required', 'min:3', 'max:10000'],
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }

            $update = auth()->user()->product_updates()->create([
                'user_id' =>  auth()->user()->id,
                'product_id' => $this->product->id,
                'title' => $this->title,
                'body' => $this->body,
            ]);
            auth()->user()->touch();
            $users = Product::find($this->product->id)->subscribers()->get();
            foreach ($users as $user) {
                $user->notify(new NewProductUpdate($update));
            }
            loggy(request(), 'Product', auth()->user(), 'Created a new product update on #'.$this->product->slug.' | Update ID: '.$update->id);

            return redirect()->route('product.updates', ['slug' => $update->product->slug]);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
