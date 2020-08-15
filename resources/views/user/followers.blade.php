@extends('layouts.app')

@section('content')
<div class="container">
    @include('user.profile')
    <div class="row justify-content-center mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @livewire('user.followers', ['user' => $user])
                </div>
                @include('user.sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
