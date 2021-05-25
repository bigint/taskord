@if (feature('year_in_review'))
<div class="alert alert-success" role="alert">
    <h5 class="alert-heading">
        <b>{{ carbon()->subYears(1)->format('Y') }}</b> Year in Review 🎉
    </h5>
    <p>
        Take a look at your productivity trends and everything you accomplished over the last 12 months in Taskord.
    </p>
    <a href="#" class="btn btn-success btn-sm text-white" target="_blank">Take a look now</a>
</div>
@endif
<div class="card">
    @auth
    @if (auth()->user()->is_staff && $user->spammy)
        <div class="p-4 pb-0">
            <div class="alert alert-danger alert-dismissible">
                This user is flagged
                {{ $user->is_suspended ? 'and suspended' : '' }}
                as spammy!
            </div>
        </div>
    @endif
    @endauth
    <div class="row">
        <div class="col-md-7">
            <div class="card-body d-flex align-items-center">
                <a href="{{ $user->avatar }}" target="_blank">
                    <img loading=lazy class="rounded-circle avatar-120" src="{{ Helper::getCDNImage($user->avatar, 240) }}" height="120" width="120" alt="{{ $user->username }}'s avatar" />
                </a>
                <div class="ms-4">
                    <div class="h5 mb-0">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                        @auth
                        @endauth
                        @if ($user->is_private)
                            <x-heroicon-o-lock-closed class="heroicon heroicon-20px text-primary ms-2 me-0 private" />
                        @endif
                        @if ($user->is_verified)
                            <x-heroicon-s-badge-check class="heroicon heroicon-20px text-primary ms-2 me-0 verified" />
                        @endif
                        @if ($user->is_patron)
                            <a class="patron" href="{{ route('patron.home') }}" aria-label="Patron">
                                <x-heroicon-s-star class="heroicon heroicon-20px ms-2 me-0 text-gold" />
                            </a>
                        @endif
                        @if ($user->vacation_mode)
                            <span title="On Vacation">
                                <x-heroicon-o-sun class="heroicon heroicon-20px ms-2 me-0 text-success" />
                            </span>
                        @endif
                        @auth
                        @if ($user->isFollowing(auth()->user()))
                            <span class="ms-2 badge bg-light text-secondary">Follows you</span>
                        @endif
                        @if (auth()->user()->staff_mode)
                            <span class="ms-2 text-secondary small">#{{ $user->id }}</span>
                        @endif
                        @endauth
                    </div>
                    <div class="text-secondary mb-3">
                        {{ "@" . $user->username }}
                    </div>
                    @livewire('user.follow', [
                        'user' => $user
                    ])
                    @if ($user->status)
                    <div class="d-inline-block border border-dark border-1 mt-3 px-2 py-1 rounded">
                        <span>{{ $user->status_emoji }}</span>
                        <span class="ms-1" title="{{ $user->status }}">{{ Str::limit($user->status, '50') }}</span>
                    </div>
                    @endif
                    @if ($user->bio)
                    <div class="mt-2">
                        {{ $user->bio }}
                    </div>
                    @endif
                    <div class="small mt-3">
                        <span>
                            <x-heroicon-o-calendar class="heroicon heroicon-15px text-secondary" />
                            Joined {{ $user->created_at->format("F Y") }}
                        </span>
                        @if ($user->location)
                        <span class="ms-3">
                            <a class="text-dark" href="https://www.google.com/maps/search/{{ urlencode($user->location) }}" target="_blank" rel="noreferrer">
                                <x-heroicon-o-map class="heroicon heroicon-15px text-secondary" />
                                {{ $user->location }}
                            </a>
                        </span>
                        @endif
                        @if ($user->company)
                        <span class="ms-3">
                            <x-heroicon-o-briefcase class="heroicon heroicon-15px text-secondary" />
                            {{ $user->company }}
                        </span>
                        @if ($user->is_staff)
                        <span class="border border-1 border-info text-info fw-bold ms-1 px-2 rounded-pill small">Staff</span>
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
                        <span class="fw-bold">
                            <x-heroicon-o-lightning-bolt class="heroicon heroicon-18px text-success" />
                            {{ number_format($user->streaks) }}
                        </span>
                        {{ pluralize('day streak', $user->streaks) }}
                    </div>
                    <div class="mt-2">
                        <span class="fw-bold">
                            <x-heroicon-o-fire class="heroicon heroicon-18px text-danger" />
                            {{ number_format($user->getPoints()) }}
                        </span>
                        {{ $user->getPoints(true) < 2 ? 'Reputation' : 'Reputations' }}
                    </div>
                    @if (auth()->check() && auth()->user()->id === $user->id)
                    <div class="mt-2">
                        <span>
                            <x-heroicon-o-sparkles class="heroicon heroicon-18px text-success" />
                            You are a
                        </span>
                        <span class="fw-bold">{{ count($level) === 0 ? 'Beginner' : $level->last()->name }}</span>
                    </div>
                    @else
                    <div class="mt-2">
                        <span>
                            <x-heroicon-o-sparkles class="heroicon heroicon-18px text-success" />
                            {{ $user->username }} is a
                        </span>
                        <span class="fw-bold">{{ count($level) === 0 ? 'Beginner' : $level->last()->name }}</span>
                    </div>
                    @endif
                    @if ($user->is_beta)
                    <div class="mt-2">
                        <span class="fw-bold">
                            <x-heroicon-o-beaker class="heroicon heroicon-18px text-info" />
                            Beta Program Member
                        </span>
                    </div>
                    @endif
                    @if ($user->is_contributor)
                    <div class="mt-2">
                        <span class="fw-bold">
                            <x-heroicon-o-chip class="heroicon heroicon-18px text-dark" />
                            Taskord Contributor
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        @if (
            !$user->is_private or
            auth()->check() and auth()->user()->id === $user->id or
            auth()->check() and auth()->user()->staff_mode
        )
        <a class="text-dark fw-bold me-4" href="{{ route('user.done', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.done') text-primary @endif me-1">Done</span>
            <span class="small fw-normal text-secondary">{{ number_format($done_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.pending', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.pending') text-primary @endif me-1">Pending</span>
            <span class="small fw-normal text-secondary">{{ number_format($pending_count) }}</span>
        </a>
        @endif
        <a class="text-dark fw-bold me-4" href="{{ route('user.products', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.products') text-primary @endif me-1">Products</span>
            <span class="small fw-normal text-secondary">{{ number_format($product_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.questions', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.questions') text-primary @endif me-1">Questions</span>
            <span class="small fw-normal text-secondary">{{ number_format($question_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.answers', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.answers') text-primary @endif me-1">Answers</span>
            <span class="small fw-normal text-secondary">{{ number_format($answer_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.milestones', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.milestones') text-primary @endif me-1">Milestones</span>
            <span class="small fw-normal text-secondary">{{ number_format($milestone_count) }}</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('user.stats', ['username' => $user->username]) }}">
            <span class="@if (Route::currentRouteName() === 'user.stats') text-primary @endif me-1">Stats</span>
        </a>
        <a class="text-dark fw-bold me-4" href="{{ route('feed.user', ['username' => $user->username]) }}" target="_blank">
            <span>
                <x-heroicon-o-rss class="heroicon text-secondary" />
                Feed
            </span>
        </a>
    </div>
</div>
