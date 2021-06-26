<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserActivity extends Component
{
    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function render(): View
    {
        return view('components.user-activity');
    }
}
