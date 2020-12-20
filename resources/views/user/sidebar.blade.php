<div class="col-sm">
    @auth
    @if (Auth::user()->staffShip)
        @livewire('user.moderator', [
            'user' => $user
        ])
    @endif
    @if (Auth::id() === $user->id)
    @section('emoji-picker')
    <script src="{{ asset('js/emoji-picker.js', config('app.env') === 'production' ? true : false) }}" defer data-turbolinks-track="true"></script>
    @stop
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Staus
        <x-beta background="light" />
    </div>
    @livewire('user.status', [
        'user' => $user
    ])
    @endif
    @endauth
    @if ($user->sponsor)
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <x-heroicon-o-heart class="heroicon text-danger" />
        Sponsor
    </div>
    <div class="mb-4">
        <a class="btn w-100 btn-outline-primary" href="{{ $user->sponsor }}" target="_blank" rel="noreferrer">
            <img loading=lazy class="rounded sponsor-icon me-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($user->sponsor)['host'] }}.ico" />
            <span class="fw-bold">Sponsor {{ '@'.$user->username }}</span>
        </a>
    </div>
    @endif
    @if ($user->website or $user->twitter or $user->twitch or $user->telegram or $user->github or $user->youtube)
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Social
    </div>
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            @if ($user->website)
            <a class="list-group-item link-dark" href="{{ $user->website }}" target="_blank" rel="noreferrer">
                <img loading=lazy class="rounded favicon me-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($user->website)['host'] }}.ico" />
                {{ Helper::removeProtocol($user->website) }}
            </a>
            @endif
            @if ($user->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $user->twitter }}" target="_blank" rel="noreferrer">
                <i class="fab fa-twitter me-1"></i>
                {{ $user->twitter }}
            </a>
            @endif
            @if ($user->twitch)
            <a class="list-group-item link-dark" href="https://twitch.tv/{{ $user->twitch }}" target="_blank" rel="noreferrer">
                <i class="fab fa-twitch me-1"></i>
                {{ $user->twitch }}
            </a>
            @endif
            @if ($user->telegram)
            <a class="list-group-item link-dark" href="https://t.me/{{ $user->telegram }}" target="_blank" rel="noreferrer">
                <i class="fab fa-telegram me-1"></i>
                {{ $user->telegram }}
            </a>
            @endif
            @if ($user->github)
            <a class="list-group-item link-dark" href="https://github.com/{{ $user->github }}" target="_blank" rel="noreferrer">
                <i class="fab fa-github me-1"></i>
                {{ $user->github }}
            </a>
            @endif
            @if ($user->youtube)
            <a class="list-group-item link-dark" href="https://youtube.com/{{ $user->youtube }}" target="_blank" rel="noreferrer">
                <i class="fab fa-youtube me-1"></i>
                {{ $user->youtube }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Products
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            @if (count($user->ownedProducts->merge($user->products)) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-cube class="heroicon-4x text-primary mb-2" />
                <div class="h4">
                    No products made
                </div>
            </div>
            @endif
            @foreach ($user->ownedProducts->merge($user->products)->take(5) as $product)
            <div class="py-2 px-3">
                <a
                    href="{{ route('product.done', ['slug' => $product->slug]) }}"
                    class="product-hover"
                    data-id="{{ $product->id }}"
                >
                    <img loading=lazy class="rounded avatar-30 ms-2" src="{{ Helper::getCDNImage($product->avatar) }}" height="50" width="50" alt="{{ $product->slug }}'s avatar" />
                </a>
                <a
                    href="{{ route('product.done', ['slug' => $product->slug]) }}"
                    class="ms-2 me-2 align-text-top fw-bold text-dark product-hover"
                    data-id="{{ $product->id }}"
                >
                    {{ $product->name }}
                </a>
            </div>
            @endforeach
        </div>
        @if (count($user->ownedProducts->merge($user->products)) > 5)
        <div class="card-footer">
            <a class="fw-bold" href="{{ route('user.products', ['username' => $user->username]) }}">
                {{ count($user->ownedProducts) + count($user->products) - 5 }} more Products
            </a>
        </div>
        @endif
    </div>
    <x-footer />
</div>
