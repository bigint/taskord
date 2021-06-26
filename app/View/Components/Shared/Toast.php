<?php

namespace App\View\Components\Shared;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toast extends Component
{
    public function render(): View
    {
        return view('components.shared.toast');
    }
}
