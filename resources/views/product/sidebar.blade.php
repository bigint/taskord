<div class="col-sm">
    @auth
    @if (Auth::user()->staffShip or Auth::id() === $product->owner->id)
    <div class="card mb-4">
        <div class="card-body d-grid">
            <button type="button" class="btn btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#newUpdateModal">
                <i class="fa fa-bell me-1"></i>
                Write a product update
            </button>
            <button type="button" class="btn mt-2 btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#editProductModal">
                <i class="fa fa-edit me-1"></i>
                Edit Product
            </button>
            <button type="button" class="btn mt-2 btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                <i class="fa fa-plus me-1"></i>
                Add Member
            </button>
        </div>
    </div>
    @livewire('product.update.new-update', [
        'product' => $product
    ])
    @livewire('product.edit-product', [
        'product' => $product
    ])
    @endif
    @livewire('product.add-member', [
        'product' => $product
    ])
    @endauth
    @if ($product->website or $product->twitter or $product->producthunt or $product->repo)
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Social
    </div>
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            @if ($product->website)
            <a class="list-group-item link-dark" href="{{ $product->website }}" target="_blank" rel="noreferrer">
                <img loading=lazy class="rounded favicon me-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($product->website)['host'] }}.ico" />
                {{ Helper::removeProtocol($product->website) }}
            </a>
            @endif
            @if ($product->producthunt)
            <a class="list-group-item link-dark" href="https://www.producthunt.com/posts/{{ $product->producthunt }}" target="_blank" rel="noreferrer">
                <i class="fab fa-product-hunt me-1"></i>
                {{ Helper::removeProtocol($product->producthunt) }}
            </a>
            @endif
            @if ($product->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $product->twitter }}" target="_blank" rel="noreferrer">
                <i class="fab fa-twitter me-1"></i>
                {{ $product->twitter }}
            </a>
            @endif
            @if ($product->repo and strlen(trim(parse_url($product->repo)['path'], '/')) !== 0)
            <a class="list-group-item link-dark" href="{{ $product->repo }}" target="_blank" rel="noreferrer">
                @if (parse_url($product->repo)['host'] === 'github.com')
                <i class="fab fa-github me-1"></i>
                @elseif (parse_url($product->repo)['host'] === 'gitlab.com')
                <i class="fab fa-gitlab me-1"></i>
                @elseif (parse_url($product->repo)['host'] === 'bitbucket.org')
                <i class="fab fa-bitbucket me-1"></i>
                @endif
                {{ trim(parse_url($product->repo)['path'], '/') }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    @if ($product->sponsor)
    <div class="text-uppercase fw-bold text-secondary pb-2">
        <i class="fa fa-heart text-danger me-1"></i>
        Sponsor
    </div>
    <div class="mb-4">
        <a class="btn w-100 btn-outline-primary" href="{{ $product->sponsor }}" target="_blank" rel="noreferrer">
            <img loading=lazy class="rounded sponsor-icon me-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($product->sponsor)['host'] }}.ico" />
            <span class="fw-bold">Sponsor {{ $product->name }}</span>
        </a>
    </div>
    @endif
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Activity by month
    </div>
    <div class="card mb-4">
        <div class="card-body">
            🚧
        </div>
    </div>
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Team
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            <div class="py-2 px-3">
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="user-hover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($product->owner->avatar) }}" alt="{{ $product->owner->username }}'s avatar" />
                </a>
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="ms-2 align-middle fw-bold text-dark user-hover"
                    data-id="{{ $product->owner->id }}"
                >
                    @if ($product->owner->firstname or $product->owner->lastname)
                        {{ $product->owner->firstname }}{{ ' '.$product->owner->lastname }}
                    @else
                        {{ $product->owner->username }}
                    @endif
                </a>
            </div>
            @foreach ($product->members()->get() as $user)
            @livewire('product.team', [
                'product' => $product,
                'user' => $user
            ])
            @endforeach
        </div>
    </div>
    @if ($product->members->contains(Auth::id()))
    @livewire('product.leave', [
        'product' => $product,
    ])
    @endif
    <x-footer />
</div>
