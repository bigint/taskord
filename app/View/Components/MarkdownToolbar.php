<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarkdownToolbar extends Component
{
    public $htmlFor;

    public function __construct($htmlFor)
    {
        $this->htmlFor = $htmlFor;
    }

    public function render(): View
    {
        return view('components.markdown-toolbar');
    }
}
