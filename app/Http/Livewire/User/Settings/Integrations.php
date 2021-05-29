<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use App\Models\Webhook;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
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

        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'name' => ['required', 'min:2', 'max:20'],
                'product' => ['nullable'],
            ]);

            if (auth()->user()->spammy) {
                toast($this, 'error', 'Your account is flagged!');
            }

            if (auth()->user()->id === $this->user->id) {
                $webhook = auth()->user()->webhooks()->create([
                    'name' => $this->name,
                    'product_id' => $this->product,
                    'token' => Str::uuid(),
                    'type' => $this->type,
                ]);
                $this->reset(['name', 'product']);
                session()->flash('created', $webhook);
                loggy(request(), 'User', auth()->user(), 'Created a new webhook | Webhook ID: '.$webhook->id);

                return toast($this, 'success', 'New webhook has been created!');
            }

            return toast($this, 'error', config('taskord.error.deny'));
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function deleteWebhook($webhookId)
    {
        if (auth()->user()->id === $this->user->id) {
            loggy(request(), 'User', auth()->user(), 'Deleted a webhook | Webhook ID: '.$webhookId);
            $webhook = Webhook::find($webhookId);
            $webhook->delete();
            $this->emit('refreshIntegrations');

            return toast($this, 'success', 'Webhook has been deleted!');
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
