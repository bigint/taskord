<div class="card">
    @auth
    @if (Auth::user()->isStaff && $user->isFlagged)
        <div class="p-4 pb-0">
            <div class="alert alert-danger alert-dismissible">
                This user is flagged
                {{ $user->isSuspended ? 'and suspended' : '' }}
                as spammy!
            </div>
        </div>
    @endif
    @endauth
    <div class="row">
        <div class="col-md-7">
            <div class="card-body d-flex align-items-center">
                <img class="rounded-circle avatar-120" src="{{ $user->avatar }}" />
                <div class="ml-4">
                    <div class="h5 mb-0">
                        {{ $user->firstname ? $user->firstname . ' ' . $user->lastname : '' }}
                        @auth
                        @if (Auth::user()->staffShip)
                            <span class="ml-2 text-secondary small">#{{ $user->id }}</span>
                        @endif
                        @endauth
                        @if ($user->isPatron)
                            <a class="ml-2 small" href="{{ route('patron.home') }}" data-toggle="tooltip" data-placement="right" title="Patron">
                                {{ Emoji::handshake() }}
                            </a>
                        @endif
                        @auth
                        @if ($user->isFollowing(Auth::user()))
                            <span class="ml-2 badge bg-light text-black-50">Follows you</span>
                        @endif
                        @endauth
                    </div>
                    <div class="text-black-50 mb-2">
                        {{ "@" . $user->username }}
                    </div>
                    @auth
                    @if (Auth::id() !== $user->id && !$user->isFlagged)
                        @livewire('user.follow', [
                            'user' => $user
                        ])
                    @endif
                    @endauth
                    <span class="small">
                        <a class="text-dark" href="{{ route('user.following', ['username' => $user->username]) }}">
                            <span class="font-weight-bold">{{ $user->followings()->count() }}</span>
                            Following
                        </a>
                        <a class="text-dark" href="{{ route('user.followers', ['username' => $user->username]) }}">
                            <span class="font-weight-bold ml-2">{{ number_format($user->followers()->count()) }}</span>
                            {{ $user->followers()->count() <= 1 ? "Follower" : "Followers" }}
                        </a>
                        <span class="font-weight-bold ml-2">
                            {{
                                number_format(
                                    $user->likes()->withType(\App\Models\Task::class)->count('id') + 
                                    $user->likes()->withType(\App\Models\Comment::class)->count('id') +
                                    $user->likes()->withType(\App\Models\Question::class)->count('id') +
                                    $user->likes()->withType(\App\Models\Answer::class)->count('id')
                                )
                            }}
                        </span>
                        {{ $user->likes()->withType(\App\Models\Task::class)->count('id') <= 1 ? "Praise" : "Praises" }}
                    </span>
                    @if ($user->bio)
                    <div class="mt-3">
                        {{ $user->bio }}
                    </div>
                    @endif
                    <div class="small mt-3">
                        <span>
                            <i class="fa fa-calendar-alt mr-1 text-black-50"></i>
                            Joined {{ Carbon::parse($user->created_at)->format("F Y") }}
                        </span>
                        @if ($user->location)
                        <span class="ml-3">
                            <a class="text-dark" target="_blank" rel="noreferrer" href="https://www.google.com/maps/search/{{ urlencode($user->location) }}">
                                <i class="fa fa-compass mr-1 text-black-50"></i>
                                {{ $user->location }}
                            </a>
                        </span>
                        @endif
                        @if ($user->company)
                        <span class="ml-3">
                            <i class="fa fa-briefcase mr-1 text-black-50"></i>
                            {{ $user->company }}
                        </span>
                        @if ($user->isStaff)
                        <span class="badge rounded-pill bg-primary ml-1">Staff</span>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card-body">
                <div class="h5">Highlights</div>
                <div class="mt-3">
                    <div>
                        <span class="font-weight-bold">{{ Emoji::fire() }} {{ number_format($user->getPoints(true)) }}</span>
                        {{ $user->getPoints(true) < 2 ? 'Reputation' : 'Reputations' }}
                    </div>
                    @if (Auth::check() && Auth::id() === $user->id)
                    <div class="mt-2">
                        <span>{{ Emoji::blossom() }} You are a</span>
                        <span class="font-weight-bold">{{ count($user->badges) === 0 ? 'Beginner' : $user->badges->last()->name }}</span>
                    </div>
                    @else
                    <div class="mt-2">
                        <span>{{ Emoji::blossom() }} {{ $user->username }} is a</span>
                        <span class="font-weight-bold">{{ count($user->badges) === 0 ? 'Beginner' : $user->badges->last()->name }}</span>
                    </div>
                    @endif
                    @if ($user->isBeta)
                    <div class="mt-2">
                        <span class="font-weight-bold">{{ Emoji::testTube() }} Beta Program Member</span>
                    </div>
                    @endif
                    @if ($user->isDeveloper)
                    <div class="mt-2">
                        <span class="font-weight-bold">{{ Emoji::checkBoxWithCheck() }} Taskord Code Contributor</span>
                    </div>
                    @endif
                </div>
            </div>  
        </div>
    </div>
    <div class="card-footer text-muted">
        @if (
            !$user->isPrivate or
            Auth::id() === $user->id or
            Auth::check() && Auth::user()->staffShip
        )
        <a class="text-dark font-weight-bold mr-4" href="{{ route('user.done', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.done') text-primary @endif">Done</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4" href="{{ route('user.pending', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.pending') text-primary @endif">Pending</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($pending_count) }}</span>
        </a>
        @endif
        <a class="text-dark font-weight-bold mr-4" href="{{ route('user.products', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.products') text-primary @endif">Products</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($product_count) }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4" href="{{ route('user.questions', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.questions') text-primary @endif">Questions</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($question_count) }}</span>
        </a>
        <a class="text-dark font-weight-bold mr-4" href="{{ route('user.answers', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.answers') text-primary @endif">Answers</span>
            <span class="small font-weight-normal text-black-50">{{ number_format($answer_count) }}</span>
        </a>
        @auth
        @if (Auth::user()->staffShip)
        <a class="text-dark font-weight-bold mr-4" href="">
            Stats
        </a>
        @endif
        @endauth
    </div>
</div>
