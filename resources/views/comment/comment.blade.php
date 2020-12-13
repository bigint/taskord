@extends('layouts.app')

@if ($comment->hidden)
@section('pageTitle', 'Hidden Comment ·')
@else
@section('pageTitle', 'Comment by @'.$comment->user->username.' ·')
@section('title', 'Comment by @'.$comment->user->username.' ·')
@section('description', $comment->comment)
@section('image', $comment->user->avatar)
@section('url', url()->current())
@endif

@section('content')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <span class="p-3">
                @livewire('task.single-task', [
                    'task' => $task
                ], key($task->id))
                </span>
            </div>
            <div class="ms-4 vertical-line"></div>
            <div class="mb-4">
            @livewire('comment.single-comment', [
                'comment' => $comment,
            ], key($comment->id))
            </div>
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn w-100 btn-success mt-4 text-white fw-bold">
                Go back to task
            </a>
        </div>
        <div class="col-sm">
            <div class="card mb-4">
                <div class="card-header">
                    Created by
                </div>
                <div class="card-body d-flex align-items-center">
                    <a
                        href="{{ route('user.done', ['username' => $comment->user->username]) }}"
                        id="user-hover"
                        data-id="{{ $comment->user->id }}"
                    >
                        <img class="rounded-circle avatar-40 mt-1" src="{{ $comment->user->avatar }}" />
                    </a>
                    <span class="ms-3">
                        <a
                            href="{{ route('user.done', ['username' => $comment->user->username]) }}"
                            class="align-text-top text-dark"
                            id="user-hover"
                            data-id="{{ $comment->user->id }}"
                        >
                            <span class="fw-bold">
                                @if ($comment->user->firstname or $comment->user->lastname)
                                    {{ $comment->user->firstname }}{{ ' '.$comment->user->lastname }}
                                @else
                                    {{ $comment->user->username }}
                                @endif
                            </span>
                            <div>{{ $comment->user->bio }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @if ($comment->likerscount() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Liked by
                </div>
                <div class="card-body align-items-center pb-2">
                    @foreach ($comment->likers as $user)
                        <a
                            title="{{ $user->firstname ? $user->firstname . ' ' . $user->lastname : $user->username }}"
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="me-1"
                        >
                            <img class="rounded-circle avatar-30 mb-2" src="{{ $user->avatar }}" />
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
