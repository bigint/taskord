<?php

use App\Http\Livewire\Milestone\CreateMilestone;
use App\Http\Livewire\Milestone\EditMilestone;
use App\Http\Livewire\Milestone\SingleMilestone;
use App\Models\Milestone;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has milestones page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones', 200, false],
    ['/milestones', 200, true],
]);

it('has new milestone page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones/new', 302, false],
    ['/milestones/new', 200, true],
]);

it('has single milestone page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/milestones/1', 200, false],
    ['/milestones/1', 200, true],
]);

it('cannot create milestone as un-authed user', function () {
    livewire(CreateMilestone::class)
        ->set('name', 'Hello world from test!')
        ->set('description', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
});

it('cannot edit milestone as un-authed user', function () {
    $milestone = Milestone::factory()->create();

    livewire(EditMilestone::class, ['milestone' => $milestone])
        ->set('name', 'Hello world from test!')
        ->set('description', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
});

it('can create milestone as authed user', function ($question, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateMilestone::class)
            ->set('name', $question)
            ->set('description', $question)
            ->call('submit')
            ->assertEmitted('refreshMilestones');
    }

    return actingAs($user)
        ->livewire(CreateMilestone::class)
        ->set('name', $question)
        ->set('description', $question)
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
})->with('model-data');

it('can edit milestone as authed user', function ($milestone, $user, $status) {
    $newMilestone = Milestone::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(EditMilestone::class, ['milestone' => $newMilestone])
            ->set('name', $milestone)
            ->set('description', $milestone)
            ->call('submit')
            ->assertEmitted('refreshMilestones');
    }

    return actingAs($user)
        ->livewire(EditMilestone::class, ['milestone' => $newMilestone])
        ->set('name', $milestone)
        ->set('description', $milestone)
        ->call('submit')
        ->assertNotEmitted('refreshMilestones');
})->with('model-data');

it('cannot toggle like on milestone', function ($user, $status) {
    $milestone = Milestone::factory()->create([
        'user_id' => $user,
    ]);

    actingAs($user)
        ->livewire(SingleMilestone::class, [
            'milestone' => $milestone,
            'type' => 'milestones.opened',
        ])
        ->call('toggleLike')
        ->assertNotEmitted('milestoneLiked');
})->with('like-data');

it('can toggle like on milestone', function ($user, $status) {
    $milestone = Milestone::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleMilestone::class, [
                'milestone' => $milestone,
                'type' => 'milestones.opened',
            ])
            ->call('toggleLike')
            ->assertEmitted('milestoneLiked');
    }

    return actingAs($user)
        ->livewire(SingleMilestone::class, [
            'milestone' => $milestone,
            'type' => 'milestones.opened',
        ])
        ->call('toggleLike')
        ->assertNotEmitted('milestoneLiked');
})->with('like-data');

it('cannot delete milestone', function ($user, $status) {
    $milestone = Milestone::factory()->create([
        'user_id' => 10,
    ]);

    actingAs($user)
        ->livewire(SingleMilestone::class, [
            'milestone' => $milestone,
            'type' => 'milestones.opened',
        ])
        ->call('deleteMilestone')
        ->assertNotEmitted('refreshMilestones');
})->with('like-data');

it('can delete milestone', function ($user, $status) {
    $milestone = Milestone::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleMilestone::class, [
                'milestone' => $milestone,
                'type' => 'milestones.opened',
            ])
            ->call('deleteMilestone')
            ->assertEmitted('refreshMilestones');
    }

    return actingAs($user)
        ->livewire(SingleMilestone::class, [
            'milestone' => $milestone,
            'type' => 'milestones.opened',
        ])
        ->call('deleteMilestone')
        ->assertNotEmitted('refreshMilestones');
})->with('like-data');
