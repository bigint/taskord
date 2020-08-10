<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Auth;
use Livewire\Component;

class EditProduct extends Component
{
    public $product;
    public $name;
    public $slug;
    public $description;
    public $website;
    public $twitter;
    public $github;
    public $producthunt;
    public $launched;
    public $confirming;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->website = $product->website;
        $this->twitter = $product->twitter;
        $this->github = $product->github;
        $this->producthunt = $product->producthunt;
        $this->launched = $product->launched;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'name' => 'required|profanity',
                'slug' => 'required|profanity|min:3|max:20|alpha_dash|unique:products,slug,'.$this->product->id,
                'description' => 'nullable|profanity',
            ],
            [
                'name.profanity' => 'Please check your words!',
                'slug.profanity' => 'Please check your words!',
                'description.profanity' => 'Please check your words!',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'name' => 'required|profanity',
                'slug' => 'required|profanity|min:3|max:20|alpha_dash|unique:products,slug,'.$this->product->id,
                'description' => 'nullable|profanity',
            ],
            [
                'name.profanity' => 'Please check your words!',
                'slug.profanity' => 'Please check your words!',
                'description.profanity' => 'Please check your words!',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $product = Product::where('id', $this->product->id)->firstOrFail();

            if (Auth::user()->staffShip or Auth::id() === $product->user->id) {
                $product->name = $this->name;
                $product->slug = $this->slug;
                $product->description = $this->description;
                $product->website = $this->website;
                $product->twitter = $this->twitter;
                $product->github = $this->github;
                $product->producthunt = $this->producthunt;
                $product->launched = $this->launched;
                $product->save();

                session()->flash('global', 'Product has been updated!');

                return redirect()->route('product.done', ['slug' => $product->slug]);
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->product->id;
    }

    public function deleteProduct()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->product->user->id) {
                $this->product->delete();
                session()->flash('product_deleted', 'Product has been deleted!');

                return redirect()->route('products.newest');
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.edit-product');
    }
}
