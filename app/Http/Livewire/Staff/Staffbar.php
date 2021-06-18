<?php

namespace App\Http\Livewire\Staff;

use App\Jobs\Clean;
use Illuminate\Support\Facades\Queue;
use Jean85\PrettyVersions;
use Livewire\Component;

class Staffbar extends Component
{
    public function clean()
    {
        Clean::dispatch();
        loggy(request(), 'Staff', auth()->user(), 'Cleaned the Application');

        return toast($this, 'success', 'Cleaning process has been initiated successfully');
    }

    public function render()
    {
        $branch_name = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $head_ref = git('rev-parse --short HEAD') ?: '0000000';
        $jobs = Queue::size();
        $version = PrettyVersions::getVersion('laravel/framework');

        return view('livewire.staff.staffbar', [
            'branch_name' => $branch_name,
            'head_ref' => $head_ref,
            'laravel_version' => $version->getShortVersion(),
            'laravel_ref' => $version->getShortReference(),
            'jobs' => number_format($jobs),
        ]);
    }
}
