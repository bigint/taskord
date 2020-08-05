@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            @livewire('question.create-question')
        </div>
    </div>
</div>
@endsection
