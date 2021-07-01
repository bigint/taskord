<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Delete extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function resetAccount()
    {
        loggy(request(), 'User', auth()->user(), 'Resetted the user account');
        $user = User::find($this->user->id);
        // Delete Task Images
        foreach ($user->tasks as $task) {
            if ($task->oembed) {
                $task->oembed->delete();
            }
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
        $this->emit('accountResetted');

        return redirect()->route('home');
    }

    public function deleteAccount()
    {
        loggy(request(), 'User', auth()->user(), 'Deleted the user account');
        $user = User::find($this->user->id);
        // Delete Task Images
        foreach ($user->tasks as $task) {
            if ($task->oembed) {
                $task->oembed->delete();
            }
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
        $this->emit('accountDeleted');

        return redirect()->route('home');
    }
}
