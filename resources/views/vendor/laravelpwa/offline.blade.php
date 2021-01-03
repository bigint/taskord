@extends('layouts.app')
@section('pageTitle', 'Offline ·')
@section('content')
<div class="container-md">
    <main>
        <h1>📶 You are offline 📶</h1>
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
