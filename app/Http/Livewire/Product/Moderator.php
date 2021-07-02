<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class Moderator extends Component
{
    public Product $product;
    public $deprecated;
    public $isVerified;
    public $readyToLoad = false;

    public function mount($product)
    {
        $this->product = $product;
        $this->deprecated = $product->deprecated;
        $this->isVerified = $product->verified_at;
    }

    public function loadModerator()
    {
        $this->readyToLoad = true;
    }

    public function markDeprecated()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->product->deprecated = ! $this->product->deprecated;
        $this->product->timestamps = false;
        $this->product->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function verifyProduct()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if ($this->product->verified_at) {
            $this->product->verified_at = null;
        } else {
            $this->product->verified_at = carbon();
        }
        $this->product->timestamps = false;
        $this->product->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function resetLogo()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->product->avatar = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text=📦';
        $this->product->timestamps = false;
        $this->product->save();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('product.done', ['slug' => $this->product->slug]);
    }

    public function releaseSlug()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->product->slug = strtolower(Str::random(6));
        $this->product->timestamps = false;
        $this->product->save();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('product.done', ['slug' => $this->product->slug]);
    }

    public function render(): View
    {
        return view('livewire.product.moderator', [
            'product' => $this->readyToLoad ? $this->product : [],
        ]);
    }
}
