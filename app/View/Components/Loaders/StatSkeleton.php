<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatSkeleton extends Component
{
    public function render(): View
    {
        return view('components.loaders.stat-skeleton');
    }
}
