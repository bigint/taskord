<?php

namespace Tests\Feature;

use App\Http\Livewire\Answer\CreateAnswer;
use App\Http\Livewire\Answer\SingleAnswer;
use App\Http\Livewire\Answer\Answers;
use App\Http\Livewire\Answer\LoadMore;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    public $user;
    public $unverified;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
        $this->unverified = User::where(['email' => 'unverified@taskord.com'])->first();
    }

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
        $this->actingAs($this->user);
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

    public function test_unverified_create_answer()
    {
        $this->actingAs($this->unverified);
        $question = Question::create([
            'user_id' => 1,
            'title' => md5(microtime()),
            'body' => md5(microtime()),
        ]);

        Livewire::test(CreateAnswer::class, ['question' => $question])
            ->set('answer', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_auth_create_answer_required()
    {
        $this->actingAs($this->user);
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
        $this->actingAs($this->user);
        $answer = Answer::create([
            'user_id' =>  $this->user->id,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own answer!');
    }

    public function test_unverified_praise_answer()
    {
        $this->actingAs($this->unverified);
        $answer = Answer::create([
            'user_id' =>  $this->user->id,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_praise_others_answer()
    {
        $this->actingAs($this->user);
        $answer = Answer::create([
            'user_id' =>  2,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own answer!');
    }

    public function test_unverified_praise_others_answer()
    {
        $this->actingAs($this->unverified);
        $answer = Answer::create([
            'user_id' =>  2,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('togglePraise')
            ->assertSeeHtml('Your email is not verified!');
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
        $this->actingAs($this->user);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' =>  1,
            'answer' => md5(microtime()),
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->call('deleteAnswer')
            ->assertEmitted('answerDeleted');
    }
    
    public function test_view_answers()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' => 1,
            'title' => "Test Question",
            'body' => "Test Question Body",
        ]);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' => $question->id,
            'answer' => "Test Answer",
        ]);

        Livewire::test(Answers::class, ['question' => $question, 'page' => 1, 'perPage' => 10])
            ->assertSeeHtml('Test Answer');
    }
    
    public function test_view_load_more_answers()
    {
        $this->actingAs($this->user);
        $question = Question::find(1);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' => $question->id,
            'answer' => "Test Answer",
        ]);

        Livewire::test(LoadMore::class, ['question' => $question, 'page' => 1, 'perPage' => 10])
            ->assertSeeHtml('Load More')
            ->call('loadMore')
            ->assertStatus(200);
    }
    
    public function test_view_single_answer()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' => 1,
            'title' => "Test Question",
            'body' => "Test Question Body",
        ]);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' => $question->id,
            'answer' => "Test Answer",
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->assertSeeHtml('Test Answer');
    }
}
