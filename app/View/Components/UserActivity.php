<?php

namespace App\View\Components;

use Illuminate\View\Component;

class UserActivity extends Component
{
    public $activity;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.user-activity');
    }
}
