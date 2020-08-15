@extends('layouts.app')

@section('pageTitle', $question->title.' / Edit · ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @livewire('question.edit-question', [
                'question' => $question
            ])
        </div>
    </div>
</div>
@endsection
