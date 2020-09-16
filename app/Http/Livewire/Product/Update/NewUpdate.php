<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\Product;
use App\Models\ProductUpdate;
use App\Notifications\NewProductUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class NewUpdate extends Component
{
    public $title;
    public $body;
    public $product;

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
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $update = ProductUpdate::create([
                'user_id' =>  Auth::id(),
                'product_id' => $this->product->id,
                'title' => $this->title,
                'body' => $this->body,
            ]);
            Auth::user()->touch();

            session()->flash('global', 'Update has been created!');
            Notification::send(
                Product::find($this->product->id)->subscribers()->get(),
                new NewProductUpdate($update)
            );

            return redirect()->route('product.updates', ['slug' => $update->product->slug]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.update.new-update');
    }
}
