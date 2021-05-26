<?php

namespace App\Http\Livewire\Staff;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Deployments extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad = false;

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function getDeployments()
    {
        $client = new Client(['http_errors' => false]);
        $deployments = $client->request('GET', 'https://gitlab.com/api/v4/projects/25370928/jobs', [
            'query' => [
                'access_token' => config('services.gitlab.pat'),
                'per_page' => 100,
                'ref' => 'master',
            ],
        ]);

        if ($deployments->getStatusCode() === 200) {
            return json_decode($deployments->getBody()->getContents());
        } else {
            return [];
        }
    }

    public function render()
    {
        return view('livewire.staff.deployments', [
            'deployments' => $this->readyToLoad ? $this->getDeployments() : [],
        ]);
    }
}
