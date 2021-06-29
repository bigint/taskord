<?php

namespace App\View\Components\Loaders;

use Illuminate\View\Component;
use Illuminate\View\View;

class FeaturedMakersSkeleton extends Component
{
    public $count;

    public function __construct($count)
    {
        $this->count = $count;
    }

    public function render(): View
    {
        return view('components.loaders.featured-makers-skeleton');
    }
}
