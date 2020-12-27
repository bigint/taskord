<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public User $user;
    public $reset_confirming;
    public $delete_confirming;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function confirmReset()
    {
        if (Auth::check()) {
            $this->reset_confirming = $this->user->id;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }

    public function resetAccount()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('User account was resetted');
                $user = User::find($this->user->id);
                // Delete Task Images
                foreach ($user->tasks as $task) {
                    foreach ($task->images ?? [] as $image) {
                        Storage::delete($image);
                    }
                }
                // Delete Product Logos
                foreach ($user->ownedProducts as $product) {
                    $product->tasks()->delete();
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
                $user->tasks()->delete();
                $user->comments()->delete();
                $user->questions()->delete();
                $user->answers()->delete();
                $user->ownedProducts()->delete();
                $user->notifications()->delete();
                $user->likes()->delete();

                return $this->alert('success', 'Your account has been resetted!', [
                    'showCancelButton' =>  false,
              ]);
            } else {
                return $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
              ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }

    public function confirmDelete()
    {
        if (Auth::check()) {
            $this->delete_confirming = $this->user->id;
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
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
                    $product->tasks()->delete();
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
                $user->tasks()->delete();
                $user->comments()->delete();
                $user->questions()->delete();
                $user->answers()->delete();
                $user->ownedProducts()->delete();
                $user->notifications()->delete();
                $user->likes()->delete();
                $user->delete();

                return redirect()->route('home');
            } else {
                return $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
              ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }
}
