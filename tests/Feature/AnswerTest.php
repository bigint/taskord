<?php

use App\Http\Livewire\Answer\CreateAnswer;
use App\Http\Livewire\Answer\SingleAnswer;
use App\Models\Answer;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('cannot create answer as un-authed user', function () {
    $question = Question::factory()->create();

    livewire(CreateAnswer::class, ['question' => $question])
        ->set('answer', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshAnswers');
});

it('can create answer as authed user', function ($answer, $user, $status) {
    $question = Question::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(CreateAnswer::class, ['question' => $question])
            ->set('answer', $answer)
            ->call('submit')
            ->assertEmitted('refreshAnswers');
    }

    return actingAs($user)
        ->livewire(CreateAnswer::class, ['question' => $question])
        ->set('answer', $answer)
        ->call('submit')
        ->assertNotEmitted('refreshAnswers');
})->with('model-data');

it('cannot toggle like on answer', function ($user, $status) {
    $answer = Answer::factory()->create([
        'user_id' => $user,
    ]);

    actingAs($user)
        ->livewire(SingleAnswer::class, ['answer' => $answer])
        ->call('toggleLike')
        ->assertNotEmitted('answerLiked');
})->with('like-data');

it('can toggle like on answer', function ($user, $status) {
    $answer = Answer::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleAnswer::class, ['answer' => $answer])
            ->call('toggleLike')
            ->assertEmitted('answerLiked');
    }

    return actingAs($user)
        ->livewire(SingleAnswer::class, ['answer' => $answer])
        ->call('toggleLike')
        ->assertNotEmitted('answerLiked');
})->with('like-data');

it('cannot delete answer', function ($user, $status) {
    $answer = Answer::factory()->create([
        'user_id' => 10,
    ]);

    actingAs($user)
        ->livewire(SingleAnswer::class, ['answer' => $answer])
        ->call('deleteAnswer')
        ->assertNotEmitted('answerLiked');
})->with('like-data');

it('can delete answer', function ($user, $status) {
    $answer = Answer::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(SingleAnswer::class, ['answer' => $answer])
            ->call('deleteAnswer')
            ->assertEmitted('refreshAnswers');
    }

    return actingAs($user)
        ->livewire(SingleAnswer::class, ['answer' => $answer])
        ->call('deleteAnswer')
        ->assertNotEmitted('answerLiked');
})->with('like-data');
