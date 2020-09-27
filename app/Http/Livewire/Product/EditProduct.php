<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;

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
    public $sponsor;
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
        $this->sponsor = $product->sponsor;
        $this->launched = $product->launched;
        $this->deprecated = $product->deprecated;
    }

    public function updatedAvatar()
    {
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required',
                'slug' => 'required|min:3|max:20|alpha_dash|unique:products,slug,'.$this->product->id,
                'description' => 'nullable',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'github' => 'nullable|alpha_dash|max:30',
                'producthunt' => 'nullable|alpha_dash|max:30',
                'sponsor' => 'nullable|active_url',
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
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
                $img = Image::make($this->avatar)
                        ->fit(400)
                        ->encode('webp', 80);
                $imageName = $this->product->id.'.png';
                Storage::disk('public')->put("logos/".$imageName, (string) $img);
                $avatar = config('app.url').'/storage/logos/'.$imageName;
                $product->avatar = $avatar;
            }

            if (Auth::user()->staffShip or Auth::id() === $product->owner->id) {
                $product->name = $this->name;
                $product->slug = $this->slug;
                $product->description = $this->description;
                $product->website = $this->website;
                $product->twitter = $this->twitter;
                $product->github = $this->github;
                $product->producthunt = $this->producthunt;
                $product->sponsor = $this->sponsor;
                $product->launched = $this->launched;
                $product->deprecated = $this->deprecated;
                $product->save();
                Auth::user()->touch();

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
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->product->owner->id) {
                $avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
                $this->product->task()->delete();
                $this->product->webhooks()->delete();
                $this->product->delete();
                Auth::user()->touch();
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
