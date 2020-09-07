<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Webhook;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Integrations extends Component
{
    public $user;
    public $name;
    public $type = 'web';

    public $listeners = [
        'webhookDeleted' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 5, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:2|max:20',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::id() === $this->user->id) {
                $webhook = Webhook::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'token' => md5(uniqid(Auth::id(), true)),
                    'type' => $this->type,
                ]);
                $this->name = '';
                session()->flash('created', $webhook);
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function deleteWebhook($id)
    {
        if (Auth::check()) {
            $webhook = Webhook::find($id);
            $webhook->delete();
            $this->emit('webhookDeleted');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
