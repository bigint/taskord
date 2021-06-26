<?php

namespace App\View\Components\Loaders;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReputationSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render(): View
    {
        return view('components.loaders.reputation-skeleton');
    }
}
