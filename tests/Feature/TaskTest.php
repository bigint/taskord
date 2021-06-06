<?php

use App\Http\Livewire\CreateTask;
use App\Http\Livewire\Task\SingleTask;
use App\Models\Task;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has task page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1', 200, false],
    ['/task/1', 200, true],
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

it('can toggle like on task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => 10,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleTask::class, ['task' => $task])
            ->call('toggleLike')
            ->assertEmitted('taskLiked');
    }

    return actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('toggleLike')
        ->assertNotEmitted('taskLiked');
})->with('like-data');

it('cannot toggle like on task', function ($user, $status) {
    $task = Task::factory()->create([
        'user_id' => $user,
    ]);

    actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('toggleLike')
        ->assertNotEmitted('taskLiked');
})->with('like-data');

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

it('can hide a task', function ($user, $status) {
    $task = Task::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleTask::class, ['task' => $task])
            ->call('hide')
            ->assertEmitted('taskHidden');
    }

    return actingAs($user)
        ->livewire(SingleTask::class, ['task' => $task])
        ->call('hide')
        ->assertNotEmitted('taskHidden');
})->with([
    [1, true],
    [2, false],
]);
