<?php

namespace Tests\Feature;

use App\Http\Livewire\Question\CreateQuestion;
use App\Http\Livewire\Question\SingleQuestion;
use App\Models\Question;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
    }

    public function test_question_url()
    {
        $response = $this->get(route('question.question', ['id' => 1]));

        $response->assertStatus(200);
    }

    public function test_question_displays_the_question_page()
    {
        $response = $this->get(route('question.question', ['id' => 1]));

        $response->assertStatus(200);
        $response->assertViewIs('question.question');
    }

    public function test_create_question()
    {
        Livewire::test(CreateQuestion::class)
            ->set('title', md5(microtime()))
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_question()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateQuestion::class)
            ->set('title', md5(microtime()))
            ->call('submit')
            ->assertHasErrors(['body' => 'required'])
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_create_question_required()
    {
        $this->actingAs($this->user);

        Livewire::test(CreateQuestion::class)
            ->call('submit')
            ->assertHasErrors([
                'title' => 'required',
                'body' => 'required',
            ])
            ->assertSeeHtml('The title field is required.')
            ->assertSeeHtml('The body field is required.');
    }

    public function test_praise_question()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' =>  $this->user->id,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.question',
        ])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own question!');

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own question!');
    }

    public function test_praise_others_question()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' => 2,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.question',
        ])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own question!');

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own question!');
    }

    public function test_delete_question()
    {
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.question',
        ])
            ->call('deleteQuestion')
            ->assertSeeHtml('Forbidden!');

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
            ->call('deleteQuestion')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_delete_question()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' => $this->user->id,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.question',
        ])
            ->call('deleteQuestion');

        $question = Question::create([
            'user_id' => $this->user->id,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
            ->call('deleteQuestion');
    }
}
