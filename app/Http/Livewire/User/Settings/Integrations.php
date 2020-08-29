<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\Webhook;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Integrations extends Component
{
    public $user;
    public $name;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|min:2|max:20',
            ]);
            if (Auth::id() === $this->user->id) {
                $webhook = Webhook::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'token' => md5(uniqid(Auth::id(), true)),
                    'type' => 'web',
                ]);
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

            return redirect()->route('user.settings.integrations');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
