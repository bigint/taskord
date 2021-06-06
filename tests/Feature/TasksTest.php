<?php

use App\Http\Livewire\Tasks\CreateTask;
use App\Http\Livewire\Tasks\SingleTask;
use App\Models\Task;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has tasks page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/tasks', 302, false],
    ['/tasks', 200, true],
]);

it('cannot create task as un-authed user', function () {
    livewire(CreateTask::class)
        ->set('task', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshTasks');
});

it('can create task as authed user', function ($task, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateTask::class)
            ->set('task', $task)
            ->call('submit')
            ->assertEmitted('refreshTasks');
    }

    return actingAs($user)
        ->livewire(CreateTask::class)
        ->set('task', $task)
        ->call('submit')
        ->assertNotEmitted('refreshTasks');
})->with('model-data');

it('cannot toggle check on task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => 10,
    ]);

    actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('checkTask')
        ->assertNotEmitted('refreshTasks');
})->with('like-data');

it('can toggle check on task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleTask::class, ['task' => $task])
            ->call('checkTask')
            ->assertEmitted('refreshTasks');
    }

    return actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('checkTask')
        ->assertNotEmitted('refreshTasks');
})->with('like-data');

it('cannot delete task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => 10,
    ]);

    actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('deleteTask')
        ->assertNotEmitted('refreshTasks');
})->with('like-data');

it('can delete task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleTask::class, ['task' => $task])
            ->call('deleteTask')
            ->assertEmitted('refreshTasks');
    }

    return actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('deleteTask')
        ->assertNotEmitted('refreshTasks');
})->with('like-data');
