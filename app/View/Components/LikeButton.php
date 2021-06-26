<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LikeButton extends Component
{
    public $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function render(): View
    {
        return view('components.like-button');
    }
}
