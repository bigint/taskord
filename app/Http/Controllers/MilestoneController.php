<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Contracts\View\View;

class MilestoneController extends Controller
{
    public function opened(): View
    {
        return view('milestones.milestones', [
            'type' => 'milestones.opened',
        ]);
    }

    public function closed(): View
    {
        return view('milestones.milestones', [
            'type' => 'milestones.closed',
        ]);
    }

    public function milestone(Milestone $milestone): View
    {
        $response = [
            'type' => 'milestones.milestone',
            'milestone' => $milestone,
        ];
        if (
            auth()->check() && auth()->user()->id === $milestone->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('milestones.milestone', $response);
        }

        if ($milestone->user->spammy or $milestone->user->is_private) {
            return abort(404);
        }

        return view('milestones.milestone', $response);
    }

    public function edit(Milestone $milestone): View
    {
        if (
            auth()->check() && auth()->user()->id === $milestone->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('milestones.edit', [
                'milestone' => $milestone,
            ]);
        }

        return abort(404);
    }

    public function popover(Milestone $milestone): View
    {
        return view('milestones.popover', [
            'milestone' => $milestone,
        ]);
    }
}
