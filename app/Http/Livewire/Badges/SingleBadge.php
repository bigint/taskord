<?php

namespace App\Http\Livewire\Badges;

use App\Models\ProfileBadge;
use Illuminate\View\View;
use Livewire\Component;

class SingleBadge extends Component
{
    public ProfileBadge $badge;

    public function mount($question)
    {
        $this->badge = $badge;
    }

    public function render(): View
    {
        return view('livewire.badges.single-badge');
    }
}
