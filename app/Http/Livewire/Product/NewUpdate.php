<?php

namespace App\Http\Livewire\Product;

use App\Notifications\NewProductUpdate;
use App\ProductUpdate;
use Auth;
use Livewire\Component;
use Notification;

class NewUpdate extends Component
{
    public $title;
    public $body;
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'title' => 'required|profanity|min:5|max:100',
                'body' => 'required|profanity|min:3|max:10000',
            ],
            [
                'title.profanity' => 'Please check your words!',
                'body.profanity' => 'Please check your words!',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'title' => 'required|profanity|min:5|max:100',
                'body' => 'required|profanity|min:3|max:10000',
            ],
            [
                'title.profanity' => 'Please check your words!',
                'body.profanity' => 'Please check your words!',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $update = ProductUpdate::create([
                'user_id' =>  Auth::id(),
                'product_id' => $this->product->id,
                'title' => $this->title,
                'body' => $this->body,
            ]);

            session()->flash('global', 'Update has been created!');
            Notification::send($this->product->subscribers, new NewProductUpdate($update));

            return redirect()->route('product.updates', ['slug' => $update->product->slug]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.new-update');
    }
}
