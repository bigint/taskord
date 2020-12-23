<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use App\Models\Webhook;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Integrations extends Component
{
    public User $user;
    public $name;
    public $product;
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
        if (count($throttler) > 10) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while creating an API integration');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
                    'name' => 'required|min:2|max:20',
                    'product' => 'nullable',
                ]);

                if (Auth::user()->isFlagged) {
                    return $this->alert('error', 'Your account is flagged!');
                }

                if (Auth::id() === $this->user->id) {
                    $webhook = Webhook::create([
                        'user_id' => Auth::id(),
                        'name' => $this->name,
                        'product_id' => $this->product,
                        'token' => md5(uniqid(Auth::id(), true)),
                        'type' => $this->type,
                    ]);
                    $this->name = '';
                    $this->product = '';
                    session()->flash('created', $webhook);
                    activity()
                        ->withProperties(['type' => 'User'])
                        ->log('New webhook has been created WH: '.$webhook->id);
                } else {
                    return $this->alert('error', 'Forbidden!');
                }
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function deleteWebhook($id)
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Webhook was deleted WH: '.$id);
                $webhook = Webhook::find($id);
                $webhook->delete();
                $this->emit('webhookDeleted');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
