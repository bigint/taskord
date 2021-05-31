<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MarkdownToolbar extends Component
{
    public $htmlFor;

    public function __construct($htmlFor)
    {
        $this->htmlFor = $htmlFor;
    }

    public function render()
    {
        return view('components.markdown-toolbar');
    }
}
