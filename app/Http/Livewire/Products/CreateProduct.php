<?php

namespace App\Http\Livewire\Products;

use App\Actions\CreateNewTask;
use App\Rules\Repo;
use App\Rules\ReservedSlug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $avatar;
    public $website;
    public $twitter;
    public $repo;
    public $producthunt;
    public $sponsor;
    public $launched;

    public function updatedAvatar()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate([
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);
    }

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate([
            'name' => ['required', 'max:30'],
            'slug' => ['required', 'min:3', 'max:20', 'unique:products', 'alpha_dash', new ReservedSlug],
            'description' => ['nullable', 'max:160'],
            'website' => ['nullable', 'active_url'],
            'twitter' => ['nullable', 'alpha_dash', 'max:30'],
            'repo' => ['nullable', 'active_url', new Repo],
            'producthunt' => ['nullable', 'alpha_dash', 'max:30'],
            'sponsor' => ['nullable', 'active_url'],
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $launched = ! $this->launched ? false : true;

        if ($launched) {
            $launched_status = true;
            $launched_at = carbon();
        } else {
            $launched_status = false;
            $launched_at = null;
        }

        if ($this->avatar) {
            $img = Image::make($this->avatar)
                    ->fit(400)
                    ->encode('webp', 100);
            $imageName = Str::orderedUuid().'.webp';
            Storage::disk('public')->put('logos/'.$imageName, (string) $img);
            $url = config('app.url').'/storage/logos/'.$imageName;
        } else {
            $url = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text=📦';
        }

        $product = auth()->user()->ownedProducts()->create([
            'name' => $this->name,
            'slug' => $this->slug,
            'avatar' => $url,
            'description' => $this->description,
            'website' => $this->website,
            'twitter' => $this->twitter,
            'repo' => $this->repo,
            'producthunt' => $this->producthunt,
            'sponsor' => $this->sponsor,
            'launched' => $launched_status,
            'launched_at' => $launched_at,
        ]);

        if ($launched_status) {
            $randomTask = Arr::random(config('taskord.tasks.templates'));
            (new CreateNewTask(auth()->user(), [
                'product_id' => $product->id,
                'task' => sprintf($randomTask, $product->slug),
                'done' => true,
                'done_at' => $product->launched_at,
                'type' => 'product',
            ]))();
        }

        auth()->user()->touch();
        loggy(request(), 'Product', auth()->user(), 'Created a new product | Product Slug: #'.$product->slug);

        return redirect()->route('product.done', ['slug' => $product->slug]);
    }

    public function render()
    {
        return view('livewire.products.create-product');
    }
}
