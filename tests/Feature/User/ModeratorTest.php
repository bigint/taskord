<?php

use App\Http\Livewire\User\Moderator;
use App\Models\User;
use function Tests\actingAs;

it('can edit (enrollBeta) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollBeta')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollBeta')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollStaff) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollStaff')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollStaff')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollDeveloper) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollDeveloper')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollDeveloper')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (privateUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('privateUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('privateUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (flagUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('flagUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('flagUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (suspendUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('suspendUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('suspendUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (enrollPatron) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('enrollPatron')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('enrollPatron')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (verifyUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('verifyUser')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('verifyUser')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);

it('can edit (masquerade) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('masquerade')
            ->assertRedirect('/');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('masquerade')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (resetAvatar) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('resetAvatar')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('resetAvatar')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

// TODO: can edit (releaseUsername) settings

it('can edit (deleteTasks) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteTasks')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteTasks')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteComments) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteComments')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteComments')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteQuestions) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteQuestions')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteQuestions')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteAnswers) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteAnswers')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteAnswers')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteMilestones) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteMilestones')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteMilestones')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteProducts) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteProducts')
            ->assertRedirect(route('user.done', ['username' => $newUser->username]));
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteProducts')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (deleteUser) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->call('deleteUser')
            ->assertRedirect('/');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->call('deleteUser')
        ->assertNoRedirect();
})->with([
    [true],
    [false],
]);

it('can edit (updateUserStaffNotes) settings', function ($status) {
    $newUser = User::factory()->create();

    if ($status) {
        return actingAs(1)
            ->livewire(Moderator::class, ['user' => $newUser])
            ->set('staffNotes', 'Test Staff Notes')
            ->call('updateUserStaffNotes')
            ->assertEmitted('modSettingsUpdated');
    }

    return actingAs($newUser->id)
        ->livewire(Moderator::class, ['user' => $newUser])
        ->set('staffNotes', 'Test Staff Notes')
        ->call('updateUserStaffNotes')
        ->assertNotEmitted('modSettingsUpdated');
})->with([
    [true],
    [false],
]);
