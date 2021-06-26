<?php

namespace App\View\Components\Shared;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserLabelWithBio extends Component
{
    public User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function render(): View
    {
        return view('components.shared.user-label-with-bio');
    }
}
