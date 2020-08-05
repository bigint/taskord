<?php

namespace App\Http\Livewire\Home;

use Auth;
use Livewire\Component;

class Onboarding extends Component
{
    public function calculateCompleteness($task_count, $praise_count, $product_count, $has_name)
    {
        $completed = [];

        if ($task_count !== 0) {
            array_push($completed, 'task_count');
        }

        if ($praise_count !== 0) {
            array_push($completed, 'task_count');
        }

        if ($product_count !== 0) {
            array_push($completed, 'task_count');
        }

        if (strlen($has_name) !== 0) {
            array_push($completed, 'has_name');
        }

        return count($completed);
    }

    public function render()
    {
        $task_count = Auth::user()->tasks->count();
        $praise_count = Auth::user()->task_praise->count();
        $product_count = Auth::user()->products->count();
        $has_name = Auth::user()->firstname;
        $changed_username = preg_match('/^[a-f0-9]{32}$/', Auth::user()->username);
        $completed = $this->calculateCompleteness(
                        $task_count,
                        $praise_count,
                        $product_count,
                        $has_name,
                    );

        return view('livewire.home.onboarding', [
            'task_count' => $task_count,
            'praise_count' => $praise_count,
            'product_count' => $product_count,
            'has_name' => $has_name,
            'changed_username' => $changed_username,
            'completed' => $completed,
        ]);
    }
}
