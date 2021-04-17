<?php

namespace App\Http\Livewire\Admin;

use App\Jobs\Clean;
use App\Jobs\Deploy;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Livewire\Component;

class Adminbar extends Component
{
    protected $listeners = [
        'refreshStats' => 'render',
    ];

    public function clean()
    {
        Clean::dispatch();
        loggy(request()->ip(), 'Admin', auth()->user(), 'Cleaned the Application');

        return $this->alert('success', 'Cleaning process has been initiated successfully 🧼');
    }

    public function deploy()
    {
        if (auth()->id() === 1) {
            Deploy::dispatch(auth()->user(), request()->ip());
            Clean::dispatch();
            loggy(request()->ip(), 'Admin', auth()->user(), 'Deployed the Application');

            return $this->alert('success', 'Deployment process has been initiated successfully 🚀');
        } else {
            return $this->alert('error', 'Permission denied!');
        }
    }

    public function render()
    {
        $branch = git('rev-parse --abbrev-ref HEAD') ?: 'main';
        $commit = git('rev-parse --short HEAD') ?: '0000000';
        $jobs = Queue::size();
        $cache = Cache::getStore()->getMemcached()->getAllKeys() ?: [];

        return view('livewire.admin.adminbar', [
            'branchname' => $branch,
            'headHASH' => $commit,
            'jobs' => number_format($jobs),
            'cache' => number_format(count($cache)),
        ]);
    }
}
