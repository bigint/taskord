<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Support\Facades\Auth;

class MilestoneController extends Controller
{
    public function opened()
    {
        return view('milestone.milestones', [
            'type' => 'milestones.opened',
        ]);
    }

    public function closed()
    {
        return view('milestone.milestones', [
            'type' => 'milestones.closed',
        ]);
    }

    public function milestone($id)
    {
        $milestone = Milestone::where('id', $id)
            ->firstOrFail();
        $response = [
            'type' => 'milestones.milestone',
            'milestone' => $milestone,
        ];
        if (
            Auth::check() && auth()->user()->id === $milestone->user->id or
            Auth::check() && auth()->user()->staffShip
        ) {
            return view('milestone/milestone', $response);
        } elseif ($milestone->user->isFlagged or $milestone->user->isPrivate) {
            return view('errors.404');
        }

        return view('milestone/milestone', $response);
    }
}
