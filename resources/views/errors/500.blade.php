@extends('layouts.app')
@section('pageTitle', 'Server Error · Taskord')
@section('code', '500')
@section('content')
<div class="container-md">
    <main>
        <h1>500</h1>
        <h2>Looks like something went wrong!</h2>
        <p>We track these errors automatically, but if the problem persists feel free to contact us. In the meantime, try refreshing.</p>
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
