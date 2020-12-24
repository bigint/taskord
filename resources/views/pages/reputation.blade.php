@extends('layouts.app')

@section('pageTitle', 'Reputation ·')
@section('title', 'Reputation ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-md">
    <div class="row justify-content-center mt-4">
        <div class="col-sm">
            <div class="card mb-4">
            <div class="card-header pt-3 pb-3">
                <span class="h5 text-success">Badges</span>
            </div>
            <div class="card-body">
                WIP
            </div>
            </div>
        </div>
        <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
            @foreach($points as $point)
            <div class="d-flex w-100 justify-content-between">
                <div class="mb-1">
                    <x-heroicon-o-sparkles class="heroicon text-secondary me-2" />
                    <span class="fw-bold">{{ $point->point }} {{ $point->point > 1 ? 'points' : 'point' }}</span>
                    @if ($point->name === 'TaskCreated')
                        earned for creating a new task 🆕
                    @endif
                    @if ($point->name === 'TaskCompleted')
                        point earned for completing a task ✅
                    @endif
                    @if ($point->name === 'QuestionCreated')
                        points earned for creating a new question ❓
                    @endif
                    @if ($point->name === 'CommentCreated')
                        points earned for creating a new comment 💬
                    @endif
                    @if ($point->name === 'GoalReached')
                        points earned for reaching the daily goal 🎯
                    @endif
                    @if ($point->name === 'PraiseCreated')
                        @if ($point->subject_type === 'App\Models\Task')
                            points earned for getting a praise for your Task 👏
                        @endif
                        @if ($point->subject_type === 'App\Models\Comment')
                            points earned for getting a praise for your Comment 👏
                        @endif
                        @if ($point->subject_type === 'App\Models\Question')
                            points earned for getting a praise for your Question 👏
                        @endif
                    @endif
                </div>
                <small class="text-secondary">{{ Carbon::parse($point->created_at)->diffForHumans() }}</small>
            </div>
            @if (! $loop->last)
            <hr/>
            @endif
            @endforeach
            <div class="mt-4">
                {{ $points->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
