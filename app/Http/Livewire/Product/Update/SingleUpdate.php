<?php

namespace App\Http\Livewire\Product\Update;

use App\Models\ProductUpdate;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleUpdate extends Component
{
    use WithRateLimiting;

    public ProductUpdate $update;

    public function mount($update)
    {
        $this->update = $update;
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->update)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if (auth()->user()->hasLiked($this->update)) {
            auth()->user()->unlike($this->update);

            return $this->update->refresh();
        }
        auth()->user()->like($this->update);

        return $this->update->refresh();
    }

    public function deleteUpdate()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->update->user->id) {
            loggy(request(), 'Product', auth()->user(), "Deleted a product update on #{$this->update->product->slug} | Update ID: {$this->update->id}");
            $this->update->delete();

            return $this->emitUp('refreshProduct');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }
}
