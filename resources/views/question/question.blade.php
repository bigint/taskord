@extends('layouts.app')

@if ($question->hidden)
@section('pageTitle', 'Hidden Question ·')
@else
@section('pageTitle', $question->title.' ·')
@section('title', 'Question by @'.$question->user->username.' ·')
@section('description', $question->title)
@section('image', $question->user->avatar)
@section('url', url()->current())
@endif

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if (session()->has('question_created'))
                <div class="alert alert-success alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-dismiss="alert"></button>
                    <i class="fa fa-check mr-1"></i>
                    {{ session('question_created') }}
                </div>
            @endif
            @if (session()->has('question_edited'))
                <div class="alert alert-success alert-dismissible fade show mt-2">
                    <button type="button" class="btn-close small" data-dismiss="alert"></button>
                    <i class="fa fa-check mr-1"></i>
                    {{ session('question_edited') }}
                </div>
            @endif
            <div class="mb-4">
                @livewire('question.single-question', [
                    'type' => $type,
                    'question' => $question,
                ])
            </div>
            @auth
            @if (!Auth::user()->isFlagged)
                @livewire('answer.create-answer', [
                    'question' => $question
                ])
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-block btn-success mt-4 text-white font-weight-bold">
                    {{ Emoji::wavingHand() }} Login or Signup to comment
                </a>
            @endguest
            @livewire('answer.answers', [
                'question' => $question,
                'page' => 1,
                'perPage' => 10
            ])
        </div>
        <div class="col-sm">
            <div class="card mb-4">
                <div class="card-header">
                    Asked by
                </div>
                <div class="card-body d-flex align-items-center">
                    <a href="{{ route('user.done', ['username' => $question->user->username]) }}">
                        <img class="rounded-circle avatar-40 mt-1" src="{{ $question->user->avatar }}" />
                    </a>
                    <span class="ml-3">
                        <a href="{{ route('user.done', ['username' => $question->user->username]) }}" class="align-text-top text-dark">
                            <span class="font-weight-bold">
                                @if ($question->user->firstname or $question->user->lastname)
                                    {{ $question->user->firstname }}{{ ' '.$question->user->lastname }}
                                @else
                                    {{ $question->user->username }}
                                @endif
                            </span>
                            <div>{{ $question->user->bio }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @auth
            <div class="card mb-4">
                <div class="card-header">
                    Subscribe this task
                </div>
                <div class="card-body d-flex align-items-center">
                    @livewire('question.subscribe', ['question' => $question])
                </div>
            </div>
            @endauth
            @if ($question->answer->count('id') > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Users Involved
                </div>
                <div class="card-body align-items-center pb-2">
                    @foreach ($question->answer->groupBy('user_id') as $answer)
                        <a
                            title="{{ $answer[0]->user->firstname ? $answer[0]->user->firstname . ' ' . $answer[0]->user->lastname : $answer[0]->user->username }}"
                            href="{{ route('user.done', ['username' => $answer[0]->user->username]) }}"
                            class="mr-1"
                        >
                            <img class="rounded-circle avatar-30 mb-2" src="{{ $answer[0]->user->avatar }}" />
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            <x-footer />
        </div>
    </div>
</div>
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "QAPage",
    "mainEntity": {
        "@type": "Question",
        "name": "{{ $question->title }}",
        "text": "{{ $question->body }}",
        "answerCount": {{ $question->answer->count('id') }},
        "upvoteCount": {{ $question->likerscount() }},
        "dateCreated": "{{ $question->created_at }}",
        "author": { "@type": "Person", "name": "{{ $question->user->username }}" },
        @foreach ($question->answer->take(1) as $answer)
        "acceptedAnswer": {
            "@type": "Answer",
            "text": "{{ $answer->answer }}",
            "dateCreated": "{{ $answer->created_at }}",
            "upvoteCount": 1,
            "url": "https://taskord.com/question/{{ $answer->question->id }}",
            "author": { "@type": "Person", "name": "{{ $answer->user->username }}" }
        },
        @endforeach
        "suggestedAnswer": [
            @foreach ($question->answer->take(10) as $answer)
            {
                "@type": "Answer",
                "text": "{{ $answer->answer }}",
                "dateCreated": "{{ $answer->created_at }}",
                "upvoteCount": {{ $answer->likerscount() }},
                "url": "https://taskord.com/question/{{ $answer->question->id }}",
                "author": { "@type": "Person", "name": "{{ $answer->user->username }}" }
            }{{ $loop->last ? '' : ',' }}
            @endforeach
        ]
    }
}
</script>
@endsection
