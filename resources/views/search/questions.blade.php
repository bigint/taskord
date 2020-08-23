@extends('layouts.app')

@section('pageTitle', 'Search ·')
@section('title', 'Search ·')
@section('description', 'Browse questions and discuss, answer, give feedbacks, etc.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    Soon
                </div>
                <div class="col-md-8">
                    <form action="/search/questions" method="GET" role="search">
                        @csrf
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" name="q" placeholder="Search users">
                            </span>
                        </div>
                    </form>
                    @if (!$questions)
                    @include('components.empty', [
                        'icon' => 'check-square',
                        'text' => 'No questions found',
                    ])
                    @else
                    @foreach ($questions as $question)
                    @livewire('questions.single-question', [
                        'type' => 'questions.newest',
                        'question' => $question,
                    ], key($question->id))
                    @endforeach
                    <div class="mt-3">
                        {{ $questions->appends(request()->input())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
