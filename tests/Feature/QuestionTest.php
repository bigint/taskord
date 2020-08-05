<?php

namespace Tests\Feature;

use App\Http\Livewire\Question\CreateQuestion;
use App\Http\Livewire\Questions\SingleQuestion;
use App\Question;
use App\User;
use Livewire;
use Tests\TestCase;

class QuestionTest extends TestCase
{
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
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);

        Livewire::test(CreateQuestion::class)
            ->set('title', md5(microtime()))
            ->call('submit')
            ->assertHasErrors(['body' => 'required'])
            ->set('body', md5(microtime()))
            ->call('submit')
            ->assertStatus(200);
    }

    public function test_auth_create_question_profanity()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);

        Livewire::test(CreateQuestion::class)
            ->set('title', 'Bitch')
            ->set('body', 'Bitch')
            ->call('submit')
            ->assertHasErrors([
                'title' => 'profanity',
                'body' => 'profanity',
            ])
            ->assertSeeHtml('Please check your words!');
    }

    public function test_auth_create_question_required()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);

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
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $question = Question::create([
            'user_id' =>  $user->id,
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
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
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
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $question = Question::create([
            'user_id' => $user->id,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.question',
        ])
            ->call('deleteQuestion');

        $question = Question::create([
            'user_id' => $user->id,
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
