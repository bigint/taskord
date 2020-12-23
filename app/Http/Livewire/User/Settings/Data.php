<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Data extends Component
{
    public User $user;
    public $confirming;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function confirmDelete()
    {
        if (Auth::check()) {
            $this->confirming = $this->user->id;
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function deleteAccount()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('User account was deleted');
                $user = User::find($this->user->id);
                // Delete Task Images
                foreach ($user->tasks as $task) {
                    foreach ($task->images ?? [] as $image) {
                        Storage::delete($image);
                    }
                }
                // Delete Product Logos
                foreach ($user->ownedProducts as $product) {
                    $product->task()->delete();
                    $product->webhooks()->delete();
                    $avatar = explode('storage/', $product->avatar);
                    if (array_key_exists(1, $avatar)) {
                        Storage::delete($avatar[1]);
                    }
                }
                // Delete User Avatar
                $avatar = explode('storage/', $user->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
                $user->likes()->delete();
                $user->notifications()->delete();
                $user->delete();

                return redirect()->route('home');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
