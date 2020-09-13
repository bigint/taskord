<div class="col-sm">
    @auth
    @if (Auth::user()->staffShip)
        @livewire('user.moderator', [
            'user' => $user
        ])
    @endif
    @endauth
    @if ($user->sponsor)
    <div class="card mb-4">
        <div class="card-header">
            Sponsor
        </div>
        <div class="card-body">
            <a class="btn btn-block btn-outline-primary">
                <img class="rounded sponsor-icon mr-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($user->sponsor)['host'] }}.ico" />
                <span class="font-weight-bold">Sponsor {{ '@'.$user->username }}</span>
            </a>
        </div>
    </div>
    @endif
    @if ($user->website or $user->twitter or $user->twitch or $user->telegram or $user->github or $user->youtube)
    <div class="card mb-4">
        <div class="card-header">
            Social
        </div>
        <ul class="list-group list-group-flush">
            @if ($user->website)
            <a class="list-group-item link-dark" href="{{ $user->website }}" target="_blank">
                <i class="fa fa-link mr-1"></i>
                {{ Helper::removeProtocol($user->website) }}
            </a>
            @endif
            @if ($user->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $user->twitter }}" target="_blank">
                <i class="fa fa-twitter mr-1"></i>
                {{ $user->twitter }}
            </a>
            @endif
            @if ($user->twitch)
            <a class="list-group-item link-dark" href="https://twitch.tv/{{ $user->twitch }}" target="_blank">
                <i class="fa fa-twitch mr-1"></i>
                {{ $user->twitch }}
            </a>
            @endif
            @if ($user->telegram)
            <a class="list-group-item link-dark" href="https://t.me/{{ $user->telegram }}" target="_blank">
                <i class="fa fa-telegram mr-1"></i>
                {{ $user->telegram }}
            </a>
            @endif
            @if ($user->github)
            <a class="list-group-item link-dark" href="https://github.com/{{ $user->github }}" target="_blank">
                <i class="fa fa-github mr-1"></i>
                {{ $user->github }}
            </a>
            @endif
            @if ($user->youtube)
            <a class="list-group-item link-dark" href="https://youtube.com/{{ $user->youtube }}" target="_blank">
                <i class="fa fa-youtube mr-1"></i>
                {{ $user->youtube }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            Products
        </div>
        <ul class="list-group list-group-flush">
            @if (count($user->ownedProducts->merge($user->products)) === 0)
            @include('components.empty', [
                'icon' => 'box-open',
                'text' => 'No products made!',
            ])
            @endif
            @foreach ($user->ownedProducts->merge($user->products)->take(5) as $product)
            <li class="list-group-item">
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}">
                    <img class="rounded avatar-30 mt-1 ml-2" src="{{ $product->avatar }}" height="50" width="50" />
                </a>
                <a href="{{ route('product.done', ['slug' => $product->slug]) }}" class="ml-2 mr-2 align-text-top font-weight-bold text-dark">
                    {{ $product->name }}
                </a>
            </li>
            @endforeach
        </ul>
        @if (count($user->ownedProducts->merge($user->products)) > 5)
        <div class="card-footer">
            <a class="font-weight-bold" href="{{ route('user.products', ['username' => $user->username]) }}">
                {{ count($user->ownedProducts) + count($user->products) - 5 }} more Products
            </a>
        </div>
        @endif
    </div>
    @include('components.footer')
</div>
