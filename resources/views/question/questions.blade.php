@extends('layouts.app')

@if ($type === 'questions.newest')
    @section('pageTitle', 'Questions / Newest ·')
    @section('title', 'Questions / Newest ·')
@elseif ($type === 'questions.unanswered')
    @section('pageTitle', 'Questions / Unanswered ·')
    @section('title', 'Questions / Unanswered ·')
@else
    @section('pageTitle', 'Questions / Popular ·')
    @section('title', 'Questions / Popular ·')
@endif
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @include('question.nav')
                @livewire('question.questions', [
                'type' => $type,
                'page' => 1,
                'perPage' => 10
                ])
            </div>
            <div class="col-sm">
                <livewire:question.trending />
                <x-footer />
            </div>
        </div>
    </div>
@endsection
