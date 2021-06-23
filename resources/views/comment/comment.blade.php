@extends('layouts.app')

@if ($comment->hidden)
    @section('pageTitle', 'Hidden Comment ·')
    @else
    @section('pageTitle', 'Comment by @' . $comment->user->username . ' ·')
    @section('title', 'Comment by @' . $comment->user->username . ' ·')
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
                            <livewire:task.single-task :task="$task" :showComments="false" :wire:key="$task->id" />
                        </span>
                    </div>
                    <div class="ms-4 vertical-line"></div>
                    <div class="mb-4">
                        <livewire:comment.single-comment :comment="$comment" :showReplyBox="true" :wire:key="$comment->id" />
                    </div>
                    <a href="{{ route('task', ['id' => $task->id]) }}"
                        class="btn w-100 btn-outline-success rounded-pill mt-4 fw-bold">
                        Go back to task
                    </a>
                </div>
                <div class="col-sm">
                    <div class="text-uppercase fw-bold text-secondary pb-2">
                        Created by
                    </div>
                    <div class="card mb-4">
                        <div class="card-body d-flex align-items-center">
                            <x:shared.user-label-with-bio :user="$comment->user" />
                        </div>
                    </div>
                    @if ($comment->likerscount() > 0)
                        <div class="text-uppercase fw-bold text-secondary pb-2">
                            Liked by
                        </div>
                        <div class="card mb-4">
                            <div class="card-body align-items-center pb-2">
                                @foreach ($comment->likers as $user)
                                    <a title="{{ $user->firstname ? $user->firstname . ' ' . $user->lastname : $user->username }}"
                                        href="{{ route('user.done', ['username' => $user->username]) }}" class="me-1">
                                        <img loading=lazy class="rounded-circle avatar-30 mb-2"
                                            src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="30" width="30"
                                            alt="{{ $user->username }}'s avatar" />
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
