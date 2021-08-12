<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserCardSkeleton extends Component
{
    public function render(): View
    {
        return view('components.loaders.user-card-skeleton');
    }
}
