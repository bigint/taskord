@extends('layouts.app')

@section('pageTitle', 'Contact ·')
@section('title', 'Contact ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
    <div class="container-md">
        <div class="row justify-content-center" style="height:70vh">
            <div class="col-lg-7 mt-5">
                @auth
                    @php
                        $username = '@' . auth()->user()->username;
                        $email = urlencode(auth()->user()->email);
                        $url = 'https://tally.so/embed/5mVVam?username=' . $username . '&email=' . $email . '&transparentBackground=1';
                    @endphp
                    <iframe src="{{ $url }}" width="100%" height="100%" frameborder="0" marginheight="0"
                        marginwidth="0"></iframe>
                @else
                    <iframe src="https://tally.so/embed/63lL53?transparentBackground=1" width="100%" height="100%"
                        frameborder="0" marginheight="0" marginwidth="0"></iframe>
                @endauth
            </div>
        </div>
    </div>
@endsection
