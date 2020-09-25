<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Api extends Component
{
    public $user;
    
    public $listeners = [
        'tokenRegenerated' => 'render',
    ];

    public function mount($user)
    {
        $this->user = $user;
    }
    
    public function regenerateToken()
    {
        $token = Str::random(60);
        Auth::user()->api_token = $token;
        Auth::user()->save();
        $this->emit('tokenRegenerated');
    }
    
    public function render()
    {
        return view('livewire.user.settings.api');
    }
}
