<?php

namespace App\Http\Livewire\Product;

use App\Product;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class NewProduct extends Component
{
    public $name;
    public $slug;
    public $description;
    public $website;
    public $twitter;
    public $github;
    public $producthunt;
    public $launched;

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'name' => 'required|profanity',
                'slug' => 'required|profanity|min:3|max:20|unique:products|alpha_dash',
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
                'slug' => 'required|profanity|min:3|max:20|unique:products|alpha_dash',
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

            $launched = ! $this->launched ? false : true;

            if ($launched) {
                $launched_status = true;
                $launched_at = Carbon::now();
                $updated_at = Carbon::now();
            } else {
                $launched_status = false;
                $launched_at = null;
            }

            $product = Product::create([
                'user_id' =>  Auth::id(),
                'name' => $this->name,
                'slug' => $this->slug,
                'avatar' => 'https://github.com/taskord.png',
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
