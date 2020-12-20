@extends('layouts.app')

@if ($task->hidden)
@section('pageTitle', 'Hidden Task ·')
@else
@section('pageTitle', $task->task.' ·')
@section('title', 'Task by @'.$task->user->username.' ·')
@section('description', $task->task)
@section('image', $task->user->avatar)
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
            @livewire('comment.comments', [
                'task' => $task,
                'page' => 1,
                'perPage' => 10
            ])
            @auth
            @if (!Auth::user()->isFlagged)
                @livewire('comment.create-comment', [
                    'task' => $task
                ])
            @endif
            @endauth
            @guest
                <a href="/login" class="btn w-100 btn-success mt-4 text-white fw-bold">
                    👋 Login or Signup to comment
                </a>
            @endguest
        </div>
        <div class="col-sm">
            <div class="card mb-4">
                <div class="card-header">
                    Created by
                </div>
                <div class="card-body d-flex align-items-center">
                    <a
                        href="{{ route('user.done', ['username' => $task->user->username]) }}"
                        class="user-popover"
                        data-id="{{ $task->user->id }}"
                    >
                        <img loading=lazy class="rounded-circle avatar-40 mt-1" src="{{ Helper::getCDNImage($task->user->avatar, 80) }}" alt="{{ $task->user->username }}'s avatar" />
                    </a>
                    <span class="ms-3">
                        <a
                            href="{{ route('user.done', ['username' => $task->user->username]) }}"
                            class="align-text-top text-dark user-popover"
                            data-id="{{ $task->user->id }}"
                        >
                            <span class="fw-bold">
                                @if ($task->user->firstname or $task->user->lastname)
                                    {{ $task->user->firstname }}{{ ' '.$task->user->lastname }}
                                @else
                                    {{ $task->user->username }}
                                @endif
                            </span>
                            <div>{{ $task->user->bio }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @if ($task->product_id)
            <div class="card mb-4">
                <div class="card-header">
                    Product
                </div>
                <div class="card-body d-flex align-items-center">
                    <a
                        href="{{ route('product.done', ['slug' => \App\Models\Product::find($task->product_id)->slug]) }}"
                        class="product-popover"
                        data-id="{{ \App\Models\Product::find($task->product_id)->id }}"
                    >
                        <img loading=lazy class="rounded avatar-40 mt-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($task->product_id)->avatar, 80) }}" />
                    </a>
                    <span class="ms-3">
                        <a
                            href="{{ route('product.done', ['slug' => \App\Models\Product::find($task->product_id)->slug]) }}"
                            class="align-text-top text-dark product-popover"
                            data-id="{{ \App\Models\Product::find($task->product_id)->id }}"
                        >
                            <span class="fw-bold">
                                {{ \App\Models\Product::find($task->product_id)->name }}
                            </span>
                            <div>{{ \App\Models\Product::find($task->product_id)->description }}</div>
                        </a>
                    </span>
                </div>
            </div>
            @endif
            @auth
            <div class="card mb-4">
                <div class="card-header">
                    Subscribe to this task
                </div>
                <div class="card-body d-flex align-items-center">
                    @livewire('task.subscribe', ['task' => $task])
                </div>
            </div>
            @endauth
            @if ($task->comments->count('id') > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Users Involved
                </div>
                <div class="card-body align-items-center pb-2">
                    @foreach ($task->comments->groupBy('user_id') as $comment)
                        <a
                            href="{{ route('user.done', ['username' => $comment[0]->user->username]) }}"
                            class="me-1 user-popover"
                            data-id="{{ $comment[0]->user->id }}"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mb-2" src="{{ Helper::getCDNImage($comment[0]->user->avatar, 80) }}" alt="{{ $comment[0]->user->username }}'s avatar" />
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            @if ($task->likerscount() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Liked by
                </div>
                <div class="card-body align-items-center pb-2">
                    @foreach ($task->likers as $user)
                        <a
                            title="{{ $user->firstname ? $user->firstname . ' ' . $user->lastname : $user->username }}"
                            href="{{ route('user.done', ['username' => $user->username]) }}"
                            class="me-1"
                        >
                            <img loading=lazy class="rounded-circle avatar-30 mb-2" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
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
