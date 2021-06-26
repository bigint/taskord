<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use App\Models\Webhook;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Livewire\Component;

class Integrations extends Component
{
    use WithRateLimiting;

    public User $user;
    public $name;
    public $product;
    public $type = 'web';

    public $listeners = [
        'refreshIntegrations' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'name' => ['required', 'max:30'],
        ]);

        $webhook = auth()->user()->webhooks()->create([
            'name' => $this->name,
            'product_id' => $this->product,
            'token' => Str::uuid(),
            'type' => $this->type,
        ]);
        $this->reset(['name', 'product', 'type']);
        session()->flash('created', $webhook);
        $this->emit('webhookCreated');
        loggy(request(), 'User', auth()->user(), "Created a new webhook | Webhook ID: {$webhook->id}");

        return toast($this, 'success', 'New webhook has been created!');
    }

    public function deleteWebhook($webhookId)
    {
        $webhook = Webhook::find($webhookId);
        if (Gate::denies('edit/delete', $webhook)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $webhook->delete();
        $this->emit('refreshIntegrations');
        loggy(request(), 'User', auth()->user(), "Deleted a webhook | Webhook ID: {$webhookId}");

        return toast($this, 'success', 'Webhook has been deleted!');
    }

    public function render(): View
    {
        return view('livewire.user.settings.integrations');
    }
}
