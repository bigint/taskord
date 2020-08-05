<?php

namespace Tests\Feature;

use App\Answer;
use App\Http\Livewire\Answer\CreateAnswer;
use App\Http\Livewire\Answer\SingleAnswer;
use App\Question;
use App\User;
use Livewire;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    public function test_create_answer()
    {
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(CreateAnswer::class, ['question' => $question])
            ->set('answer', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_answer()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(CreateAnswer::class, ['question' => $question])
            ->set('answer', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Answer has been added!');
    }

    public function test_auth_create_answer_profanity()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(CreateAnswer::class, ['question' => $question])
            ->set('answer', 'Bitch')
            ->call('submit')
            ->assertHasErrors([
                'answer' => 'profanity',
            ])
            ->assertSeeHtml('Please check your words!');
    }

    public function test_auth_create_answer_required()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(CreateAnswer::class, ['question' => $question])
            ->call('submit')
            ->assertHasErrors([
                'answer' => 'required',
            ])
            ->assertSeeHtml('The answer field is required.');
    }

    public function test_praise_answer()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $answer = Answer::create([
            'user_id' =>  $user->id,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own answer!');
    }

    public function test_praise_others_answer()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $answer = Answer::create([
            'user_id' =>  2,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own answer!');
    }

    public function test_delete_answer()
    {
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('deleteAnswer')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_delete_answer()
    {
        $user = User::where(['email' => 'dabbit@tuta.io'])->first();
        $this->actingAs($user);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('deleteAnswer')
            ->assertEmitted('answerDeleted');
    }
}
