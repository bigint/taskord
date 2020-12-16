@extends('layouts.app')

@section('pageTitle', 'Admin - Tasks ·')
@section('title', 'Admin - Tasks ·')
@section('description', 'Get things done socially with Taskord.')
@section('image', '')
@section('url', url()->current())

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="container-md">
            @include('admin.nav')
            <div class="card">
                <div class="card-header h6 pt-3 pb-3">
                    <div class="h5">Activities</div>
                    <span class="fw-bold">{{ $count }}</span>
                    total activities
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless text-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="w-25">TimeStamp</th>
                                <th scope="col" class="w-25">Caused by</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td class="w-25 text-black-50">
                                    {{ Carbon::parse($activity->created_at)->format('l, d M Y H:i:s') }} UTC
                                </td>
                                <td>
                                    @if($activity->causer_id)
                                    @php
                                    $username = App\Models\User::find($activity->causer_id)->username;
                                    @endphp
                                    <a href="{{ route('user.done', ['username' => $username]) }}">
                                        {{ '@' . $username }}
                                    </a>
                                    @else
                                    <span>Anon</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $activity->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
