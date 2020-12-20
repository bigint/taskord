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
                                <th scope="col">Caused by</th>
                                <th scope="col">Type</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->id }}</td>
                                <td class="w-25 text-secondary">
                                    {{ Carbon::parse($activity->created_at)->format('l, d M Y H:i:s') }} UTC
                                </td>
                                <td>
                                    @if($activity->causer_id)
                                        @php
                                        $user = App\Models\User::find($activity->causer_id);
                                        @endphp
                                        @if ($user)
                                        <img loading=lazy class="avatar-20 mb-1 me-1 rounded-circle" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
                                        <a
                                            class="user-popover"
                                            data-id="{{ $user->id }}"
                                            href="{{ route('user.done', ['username' => $user->username]) }}"
                                        >
                                            {{ '@' . $user->username }}
                                        </a>
                                        @else
                                        <span class="text-danger">Deleted User</span>
                                        @endif
                                    @else
                                    <span class="text-info">Anonymous</span>
                                    @endif
                                </td>
                                <td>
                                    @if (count($activity->properties) !== 0)
                                        @if ($activity->getExtraProperty('type') === 'Admin')
                                            🛡 Admin
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Auth')
                                            🚪 Auth
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Task')
                                            ✅ Task
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Answer')
                                            💬 Answer
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Comment')
                                            💬 Comment
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Question')
                                            ❓ Question
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'User')
                                            👤 User
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Product')
                                            📦 Product
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Notification')
                                            🔔 Notification
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Search')
                                            🔍 Search
                                        @endif
                                        @if ($activity->getExtraProperty('type') === 'Throttle')
                                            🛑 Throttled
                                        @endif
                                    @else
                                        🌐 Others
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
