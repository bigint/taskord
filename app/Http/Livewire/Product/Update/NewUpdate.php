<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\Product;
use App\Models\ProductUpdate;
use App\Notifications\NewProductUpdate;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $this->validate([
                'title' => 'required|min:5|max:100',
                'body' => 'required|min:3|max:10000',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $update = ProductUpdate::create([
                'user_id' =>  Auth::id(),
                'product_id' => $this->product->id,
                'title' => $this->title,
                'body' => $this->body,
            ]);
            Auth::user()->touch();
            $users = Product::find($this->product->id)->subscribers()->get();
            foreach ($users as $user) {
                $user->notify(new NewProductUpdate($update));
            }
            activity()
                ->withProperties(['type' => 'Product'])
                ->log('Created a new product update on #'.$this->product->slug.' | Update ID: '.$update->id);

            $this->flash('success', 'New Update has been created!');

            return redirect()->route('product.updates', ['slug' => $update->product->slug]);
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }
}
