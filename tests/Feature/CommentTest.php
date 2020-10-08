<?php

namespace Tests\Feature;

use App\Http\Livewire\Comment\CreateComment;
use App\Http\Livewire\Comment\SingleComment;
use App\Http\Livewire\Comment\LoadMore;
use App\Http\Livewire\Comment\Comments;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public $user;
    public $unverified;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::where(['email' => 'test@taskord.com'])->first();
        $this->unverified = User::where(['email' => 'unverified@taskord.com'])->first();
    }

    public function test_create_comment()
    {
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_comment()
    {
        $this->actingAs($this->user);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Comment has been added!');
    }

    public function test_unverified_create_comment()
    {
        $this->actingAs($this->unverified);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_auth_create_comment_required()
    {
        $this->actingAs($this->user);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'source' => 'PHPUnit',
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->call('submit')
            ->assertHasErrors([
                'comment' => 'required',
            ])
            ->assertSeeHtml('The comment field is required.');
    }

    public function test_praise_comment()
    {
        $this->actingAs($this->user);
        $comment = Comment::create([
            'user_id' =>  $this->user->id,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own comment!');
    }

    public function test_unverified_praise_comment()
    {
        $this->actingAs($this->unverified);
        $comment = Comment::create([
            'user_id' =>  $this->user->id,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('togglePraise')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_praise_others_task_comment()
    {
        $this->actingAs($this->user);
        $comment = Comment::create([
            'user_id' =>  2,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own comment!');
    }

    public function test_unverified_praise_others_task_comment()
    {
        $this->actingAs($this->unverified);
        $comment = Comment::create([
            'user_id' =>  2,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('togglePraise')
            ->assertSeeHtml('Your email is not verified!');
    }

    public function test_delete_task_comment()
    {
        $comment = Comment::create([
            'user_id' =>  1,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('deleteComment')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_delete_task_comment()
    {
        $this->actingAs($this->user);
        $comment = Comment::create([
            'user_id' =>  $this->user->id,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $comment])
            ->call('deleteComment')
            ->assertEmitted('commentDeleted');
    }
    
    public function test_view_comments()
    {
        $this->actingAs($this->user);
        $question = Question::create([
            'user_id' => 1,
            'title' => 'Test Question',
            'body' => 'Test Question Body',
        ]);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' => $question->id,
            'answer' => 'Test Answer',
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
            'answer' => 'Test Answer',
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
            'title' => 'Test Question',
            'body' => 'Test Question Body',
        ]);
        $answer = Answer::create([
            'user_id' =>  1,
            'question_id' => $question->id,
            'answer' => 'Test Answer',
        ]);

        Livewire::test(SingleAnswer::class, ['answer' => $answer])
            ->assertSeeHtml('Test Answer');
    }
}
