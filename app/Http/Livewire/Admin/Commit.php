<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use GuzzleHttp\Client;

class Commit extends Component
{
    public $readyToLoad = false;
    
    public function loadCommitData()
    {
        $this->readyToLoad = true;
    }
    
    public function render()
    {
        $client = new Client();
        $commit = $client->request('GET', 'https://gitlab.com/api/v4/projects/20359920/repository/commits', [
            'query' => [
                'per_page' => 1,
            ],
        ]);

        $res = json_decode($commit->getBody()->getContents())[0];

        return view('livewire.admin.commit', [
            'commit' => $this->readyToLoad ? $res : [],
        ]);
    }
}
