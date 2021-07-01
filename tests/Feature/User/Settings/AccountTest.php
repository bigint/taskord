<?php

use App\Http\Livewire\User\Settings\Account;
use App\Models\User;
use Illuminate\Support\Str;
use function Tests\actingAs;

it('has settings/account page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/account', 302, false],
    ['/settings/account', 200, true],
]);

it('can edit account (enrollBeta) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Account::class, ['user' => $newUser])
        ->call('enrollBeta')
        ->assertEmitted('enrolledBeta');
});

it('can edit account (enrollPrivate) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
            ->livewire(Account::class, ['user' => $newUser])
            ->call('enrollPrivate')
            ->assertEmitted('enrolledPrivate');
});

it('can edit account (updateAccount) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
            ->livewire(Account::class, ['user' => $newUser])
            ->set('email', Str::random(8).'@gmail.com')
            ->set('username', Str::random(8))
            ->call('updateAccount')
            ->assertEmitted('accountUpdated');
});
