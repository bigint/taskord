<?php

namespace App\Http\Livewire\Home;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Onboarding extends Component
{
    public function calculateCompleteness($taskCount, $likeCount, $productCount, $hasName)
    {
        $completed = [];

        if ($taskCount !== 0) {
            array_push($completed, 'task_count');
        }

        if ($likeCount !== 0) {
            array_push($completed, 'like_count');
        }

        if ($productCount !== 0) {
            array_push($completed, 'product_count');
        }

        if (strlen($hasName) !== 0) {
            array_push($completed, 'has_name');
        }

        return count($completed);
    }

    public function render(): View
    {
        $taskCount = auth()->user()->tasks()->count('id');
        $likeCount = auth()->user()->likes(Task::class)->count();
        $productCount = auth()->user()->ownedProducts->count('id');
        $hasName = auth()->user()->firstname;
        $changedUsername = preg_match('/^[a-f0-9]{32}$/', auth()->user()->username);
        $completed = $this->calculateCompleteness(
                        $taskCount,
                        $likeCount,
                        $productCount,
                        $hasName,
                    );

        return view('livewire.home.onboarding', [
            'task_count' => $taskCount,
            'like_count' => $likeCount,
            'product_count' => $productCount,
            'has_name' => $hasName,
            'changed_username' => $changedUsername,
            'completed' => $completed,
        ]);
    }
}
