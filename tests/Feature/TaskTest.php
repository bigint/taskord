<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateTask;
use App\Http\Livewire\Task\SingleTask;
use App\Models\Task;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public $user;
    public $unverified;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
        $this->unverified = User::where(['email' => 'unverified@taskord.com'])->first();
    }

    public function test_task_url()
    {
        $response = $this->get(route('task', ['id' => 1]));

        $response->assertStatus(200);
    }

    public function test_task_displays_the_task_page()
    {
        $response = $this->get(route('task', ['id' => 1]));

        $response->assertStatus(200);
        $response->assertViewIs('task.task');
    }

    public function test_create_task()
    {
        Livewire::test(CreateTask::class, [
            'type' => 'user',
            'product_id' => null,
        ])
            ->set('task', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_task()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateTask::class, [
            'type' => 'user',
            'product_id' => null,
        ])
            ->set('task', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Task has been created!');
    }
    
    public function test_unverified_create_task()
    {
        $this->actingAs($this->unverified);

        Livewire::test(CreateTask::class, [
            'type' => 'user',
            'product_id' => null,
        ])
            ->set('task', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_auth_create_task_required()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateTask::class, [
            'type' => 'user',
            'product_id' => null,
        ])
            ->call('submit')
            ->assertHasErrors([
                'task' => 'required',
            ])
            ->assertSeeHtml('The task field is required.');
    }

    public function test_praise_task()
    {
        $this->actingAs($this->user);
        $task = Task::create([
            'user_id' => $this->user->id,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(SingleTask::class, ['task' => $task])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own task!');
    }

    public function test_praise_others_task()
    {
        $this->actingAs($this->user);
        $task = Task::create([
            'user_id' => 2,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(SingleTask::class, ['task' => $task])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own task!');
    }
    
    public function test_unverified_praise_others_task()
    {
        $this->actingAs($this->unverified);
        $task = Task::create([
            'user_id' => 2,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(SingleTask::class, ['task' => $task])
            ->call('togglePraise')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_delete_task()
    {
        $this->actingAs($this->user);
        $task = Task::create([
            'user_id' => $this->user->id,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(SingleTask::class, ['task' => $task])
            ->call('deleteTask')
            ->assertEmitted('taskDeleted');
    }
}
