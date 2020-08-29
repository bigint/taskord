<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Webhook;

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
            if (Auth::id() === $this->user->id) {
                $webhook = Webhook::create([
                    'user_id' => Auth::id(),
                    'name' => $this->name,
                    'token' => md5(Auth::id().Carbon::now()),
                    'type' => 'web',
                ]);
                dd($webhook);
                session()->flash('success', 'Webhook has been created!');
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.integrations');
    }
}
