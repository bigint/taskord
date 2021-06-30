<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class EditBadge extends Component
{
    public ProfileBadge $badge;
    public $title;
    public $icon;
    public $color;

    public function mount($badge)
    {
        $this->badge = $badge;
        $this->title = $badge->title;
        $this->icon = $badge->icon;
        $this->color = '';
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:30'],
            'color' => ['required', 'max:10'],
            'icon' => ['required', 'active_url'],
        ]);

        $badge = ProfileBadge::where('id', $this->badge->id)->firstOrFail();

        if ($badge->title !== $this->title) {
            $titleSlug = Str::slug(Str::limit($this->title, 240));
            $randomForSlug = Str::lower(Str::random(10));
            $badge->slug = $titleSlug.'-'.$randomForSlug;
        }

        $badge->title = trim($this->title);
        $badge->icon = trim($this->icon);
        $badge->color = '#'.trim($this->color);
        $badge->save();

        $this->emit('refreshBadges');
        loggy(request(), 'Badge', auth()->user(), "Updated a badge | Badge ID: {$badge->id}");

        return redirect()->route('badges.badge', ['slug' => $badge->slug]);
    }

    public function render(): View
    {
        return view('livewire.badges.edit-badge');
    }
}
