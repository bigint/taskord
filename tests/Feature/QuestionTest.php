<?php

use App\Http\Livewire\Question\CreateQuestion;
use App\Http\Livewire\Question\EditQuestion;
use App\Http\Livewire\Question\SingleQuestion;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has questions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/questions', 200, false],
    ['/questions', 200, true],
]);

it('has new question page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/questions/new', 302, false],
    ['/questions/new', 200, true],
]);

it('cannot create question as un-authed user', function () {
    livewire(CreateQuestion::class)
        ->set('title', 'Hello world from test!')
        ->set('body', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
});

it('cannot edit question as un-authed user', function () {
    $question = Question::factory()->create();

    livewire(EditQuestion::class, ['question' => $question])
        ->set('title', 'Hello world from test!')
        ->set('body', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
});

it('can create question as authed user', function ($question, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateQuestion::class)
            ->set('title', $question)
            ->set('body', $question)
            ->call('submit')
            ->assertEmitted('refreshQuestion');
    }

    return actingAs($user)
        ->livewire(CreateQuestion::class)
        ->set('title', $question)
        ->set('body', $question)
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
})->with('model-data');

it('can edit question as authed user', function ($question, $user, $status) {
    $newQuestion = Question::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(EditQuestion::class, ['question' => $newQuestion])
            ->set('title', $question)
            ->set('body', $question)
            ->call('submit')
            ->assertEmitted('refreshQuestion');
    }

    return actingAs($user)
        ->livewire(EditQuestion::class, ['question' => $newQuestion])
        ->set('title', $question)
        ->set('body', $question)
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
})->with('model-data');

it('cannot toggle like on question', function ($user, $status) {
    $question = Question::factory()->create([
        'user_id' => $user,
    ]);

    actingAs($user)
        ->livewire(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
        ->call('toggleLike')
        ->assertNotEmitted('questionLiked');
})->with('like-data');

it('can toggle like on question', function ($user, $status) {
    $question = Question::factory()->create([
        'user_id' => 10,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleQuestion::class, [
                'question' => $question,
                'type' => 'question.newest',
            ])
            ->call('toggleLike')
            ->assertEmitted('questionLiked');
    }

    return actingAs($user)
        ->livewire(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
        ->call('toggleLike')
        ->assertNotEmitted('questionLiked');
})->with('like-data');

it('cannot delete question', function ($user, $status) {
    $question = Question::factory()->create([
        'user_id' => 10,
    ]);

    actingAs($user)
        ->livewire(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
        ->call('deleteQuestion')
        ->assertNotEmitted('refreshQuestions');
})->with('like-data');

it('can delete question', function ($user, $status) {
    $question = Question::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleQuestion::class, [
                'question' => $question,
                'type' => 'question.newest',
            ])
            ->call('deleteQuestion')
            ->assertEmitted('refreshQuestions');
    }

    return actingAs($user)
        ->livewire(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
        ->call('deleteQuestion')
        ->assertNotEmitted('refreshQuestions');
})->with('like-data');

it('can hide a question', function ($user, $status) {
    $question = Question::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleQuestion::class, [
                'question' => $question,
                'type' => 'question.newest',
            ])
            ->call('hide')
            ->assertEmitted('questionHidden');
    }

    return actingAs($user)
        ->livewire(SingleQuestion::class, [
            'question' => $question,
            'type' => 'question.newest',
        ])
        ->call('hide')
        ->assertNotEmitted('questionHidden');
})->with([
    [1, true],
    [2, false],
]);
