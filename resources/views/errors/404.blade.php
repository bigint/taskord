@extends('layouts.app')
@section('pageTitle', 'Page not found ·')
@section('code', '404')
@section('content')
    <div class="container-md">
        <main>
            <h1>404</h1>
            <h2>Page not found</h2>
            <p>This is not the web page you are looking for.</p>
            <p class="mt-3">
                <a class="text-secondary" href="{{ route('contact') }}">Taskord Support</a> —
                <a class="text-secondary" href="https://status.taskord.com">Taskord Status</a> —
                <a class="text-secondary" href="https://twitter.com/taskord">@taskord</a>
            </p>
        </main>
    </div>
    <style>
        main {
            align-items: center;
            display: flex;
            flex-direction: column;
            height: 90vh;
            justify-content: center;
            text-align: center;
        }

        h1 {
            font-size: 10rem;
            letter-spacing: .10em;
        }

    </style>
@endsection
