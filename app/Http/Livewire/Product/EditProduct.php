<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product;
    public $name;
    public $slug;
    public $description;
    public $avatar;
    public $website;
    public $twitter;
    public $github;
    public $producthunt;
    public $launched;
    public $deprecated;
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
        $this->deprecated = $product->deprecated;
    }

    public function updatedAvatar()
    {
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'name' => 'required',
                'slug' => 'required|min:3|max:20|alpha_dash|unique:products,slug,'.$this->product->id,
                'description' => 'nullable',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'github' => 'nullable|alpha_dash|max:30',
                'producthunt' => 'nullable|alpha_dash|max:30',
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $product = Product::where('id', $this->product->id)->firstOrFail();

            if ($this->avatar) {
                $old_avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $avatar = $this->avatar->store('logos');
                $product->avatar = config('app.url').'/storage/'.$avatar;
            }

            if (Auth::user()->staffShip or Auth::id() === $product->user->id) {
                $product->name = $this->name;
                $product->slug = $this->slug;
                $product->description = $this->description;
                $product->website = $this->website;
                $product->twitter = $this->twitter;
                $product->github = $this->github;
                $product->producthunt = $this->producthunt;
                $product->launched = $this->launched;
                $product->deprecated = $this->deprecated;
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
            if (!Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }
            
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->product->user->id) {
                $avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
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
