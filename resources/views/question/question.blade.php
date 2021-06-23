@extends('layouts.app')

@if ($question->hidden)
    @section('pageTitle', 'Hidden Question ·')
@else
    @section('pageTitle', $question->title . ' ·')
    @section('title', 'Question by @' . $question->user->username . ' ·')
    @section('description', $question->title)
    @section('image', $question->user->avatar)
    @section('url', url()->current())
@endif

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    @livewire('question.single-question', [
                    'type' => $type,
                    'question' => $question,
                    ])
                </div>
                @auth
                    @if (!auth()->user()->spammy)
                        @livewire('answer.create-answer', [
                        'question' => $question
                        ])
                    @endif
                @endauth
                @guest
                    <a href="/login" class="btn w-100 btn-outline-primary rounded-pill mt-4 fw-bold">
                        👋 Login or Signup to comment
                    </a>
                @endguest
                @livewire('answer.answers', [
                'question' => $question,
                'page' => 1,
                'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <div class="fw-bold text-secondary pb-2">
                    Asked by
                </div>
                <div class="card mb-4">
                    <div class="card-body d-flex align-items-center">
                        <x:shared.user-label-with-bio :user="$question->user" />
                    </div>
                </div>
                @auth
                    <div class="fw-bold text-secondary pb-2">
                        Subscribe to this question
                    </div>
                    <div class="card mb-4">
                        <div class="card-body d-flex align-items-center">
                            @livewire('question.subscribe', ['question' => $question])
                        </div>
                    </div>
                @endauth
                @if (count($question->tagNames()) > 0)
                    <div class="fw-bold text-secondary pb-2">
                        Tags
                        <x:labels.beta />
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            @foreach ($question->tags as $tag)
                                <span class="border-primary border badge bg-tag me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($question->answers_count > 0)
                    <div class="fw-bold text-secondary pb-2">
                        Users Involved
                    </div>
                    <div class="card mb-4">
                        <div class="card-body align-items-center pb-2">
                            @foreach ($question->answers->groupBy('user_id') as $answer)
                                <a href="{{ route('user.done', ['username' => $answer[0]->user->username]) }}"
                                    class="me-1 user-popover" data-id="{{ $answer[0]->user->id }}">
                                    <img loading=lazy class="rounded-circle avatar-30 mb-2"
                                        src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}" height="30"
                                        width="30" alt="{{ $answer[0]->user->username }}'s avatar" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <x-footer />
            </div>
        </div>
    </div>
@endsection
