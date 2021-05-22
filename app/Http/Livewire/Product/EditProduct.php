<?php

namespace App\Http\Livewire\Product;

use App\Actions\CreateNewTask;
use App\Models\Product;
use App\Rules\Repo;
use App\Rules\ReservedSlug;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public Product $product;
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
    public $deprecated;

    public function mount($product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->website = $product->website;
        $this->twitter = $product->twitter;
        $this->repo = $product->repo;
        $this->producthunt = $product->producthunt;
        $this->sponsor = $product->sponsor;
        $this->launched = $product->launched;
        $this->deprecated = $product->deprecated;
    }

    public function updatedAvatar()
    {
        if (auth()->check()) {
            $this->validate([
                'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'name' => ['required', 'max:30'],
                'slug' => ['required', 'min:3', 'max:20', 'alpha_dash', 'unique:products,slug,'.$this->product->id, new ReservedSlug],
                'description' => ['nullable', 'max:160'],
                'website' => ['nullable', 'active_url'],
                'twitter' => ['nullable', 'alpha_dash', 'max:30'],
                'repo' => ['nullable', 'active_url', new Repo],
                'producthunt' => ['nullable', 'alpha_dash', 'max:30'],
                'sponsor' => ['nullable', 'active_url'],
                'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            $product = Product::where('id', $this->product->id)->firstOrFail();

            if ($this->avatar) {
                $old_avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $img = Image::make($this->avatar)
                        ->fit(400)
                        ->encode('webp', 100);
                $imageName = Str::orderedUuid().'.webp';
                Storage::disk('public')->put('logos/'.$imageName, (string) $img);
                $avatar = config('app.url').'/storage/logos/'.$imageName;
                $product->avatar = $avatar;
            }

            if (auth()->user()->staffShip or auth()->user()->id === $product->owner->id) {
                $isNewelyLaunched = false;

                if ($this->launched and ! $product->launched) {
                    $product->launched_at = carbon();
                    $isNewelyLaunched = true;
                }

                $product->name = $this->name;
                $product->slug = $this->slug;
                $product->description = $this->description;
                $product->website = $this->website;
                $product->twitter = $this->twitter;
                $product->repo = $this->repo;
                $product->producthunt = $this->producthunt;
                $product->sponsor = $this->sponsor;
                $product->launched = $this->launched;
                $product->deprecated = $this->deprecated;
                $product->save();

                if ($isNewelyLaunched) {
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

                loggy(request(), 'Product', auth()->user(), 'Updated a product | Product Slug: #'.$this->product->slug);

                return redirect()->route('product.done', ['slug' => $product->slug]);
            } else {
                toast($this, 'error', 'Forbidden!');
            }
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteProduct()
    {
        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->product->owner->id) {
                loggy(request(), 'Product', auth()->user(), 'Deleted a product | Product Slug: #'.$this->product->slug);
                $avatar = explode('storage/', $this->product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
                $this->product->tasks()->delete();
                $this->product->webhooks()->delete();
                $this->product->delete();
                auth()->user()->touch();

                return redirect()->route('products.newest');
            } else {
                toast($this, 'error', 'Forbidden!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
