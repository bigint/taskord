<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $avatar;
    public $website;
    public $twitter;
    public $github;
    public $producthunt;
    public $launched;

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
                'slug' => 'required|min:3|max:20|unique:products|alpha_dash',
                'description' => 'nullable',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'github' => 'nullable|alpha_dash|max:30',
                'producthunt' => 'nullable|alpha_dash|max:30',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $launched = ! $this->launched ? false : true;

            if ($launched) {
                $launched_status = true;
                $launched_at = Carbon::now();
            } else {
                $launched_status = false;
                $launched_at = null;
            }

            if ($this->avatar) {
                $avatar = $this->avatar->store('logos');
                $url = config('app.url').'/storage/'.$avatar;
            } else {
                $url = 'https://avatar.tobi.sh/'.md5($this->slug).'.svg?text=📦';
            }

            $product = Product::create([
                'user_id' =>  Auth::id(),
                'name' => $this->name,
                'slug' => $this->slug,
                'avatar' => $url,
                'description' => $this->description,
                'website' => $this->website,
                'twitter' => $this->twitter,
                'github' => $this->github,
                'producthunt' => $this->producthunt,
                'launched' => $launched_status,
                'launched_at' => $launched_at,
            ]);

            session()->flash('global', 'Product has been created!');

            return redirect()->route('product.done', ['slug' => $product->slug]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.product.new-product');
    }
}
