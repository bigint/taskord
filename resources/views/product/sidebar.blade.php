<div class="col-sm">
    @auth
        @if (auth()->user()->staff_mode or auth()->user()->id === $product->owner->id)
            <div class="card mb-4">
                <div class="card-body d-grid">
                    <button type="button" class="btn btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#newUpdateModal">
                        <x-heroicon-o-bell class="heroicon" />
                        Write a product update
                    </button>
                    <a href="{{ route('product.edit', ['slug' => $product->slug]) }}" class="btn mt-2 btn-success text-white fw-bold">
                        <x-heroicon-o-pencil class="heroicon" />
                        Edit Product
                    </a>
                    <button type="button" class="btn mt-2 btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        <x-heroicon-o-plus class="heroicon" />
                        Add Member
                    </button>
                </div>
            </div>
            @livewire('product.update.new-update', [
                'product' => $product
            ])
        @endif
        @livewire('product.add-member', [
            'product' => $product
        ])
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Activity Graph
    </div>
    <div class="card mb-4">
        @livewire('product.graph', [
            'product' => $product
        ])
    </div>
    @if ($product->website or $product->twitter or $product->producthunt or $product->repo)
        <div class="text-uppercase fw-bold text-secondary pb-2">
            Social
        </div>
        <div class="card mb-4">
            <ul class="list-group list-group-flush">
                @if ($product->website)
                    <a class="list-group-item link-dark" href="{{ $product->website }}" target="_blank" rel="noreferrer">
                        <img loading=lazy class="rounded favicon me-1" rel="preload" src="https://favicon.splitbee.io/?url={{ parse_url($product->website)['host'] }}" />
                        {{ Helper::removeProtocol($product->website) }}
                    </a>
                @endif
                @if ($product->producthunt)
                    <a class="list-group-item link-dark" href="https://www.producthunt.com/posts/{{ $product->producthunt }}" target="_blank" rel="noreferrer">
                        <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/producthunt_tzL4ouGeqn.svg" loading=lazy />
                        {{ Helper::removeProtocol($product->producthunt) }}
                    </a>
                @endif
                @if ($product->twitter)
                    <a class="list-group-item link-dark" href="https://twitter.com/{{ $product->twitter }}" target="_blank" rel="noreferrer">
                        <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg" loading=lazy />
                        {{ $product->twitter }}
                    </a>
                @endif
                @if ($product->repo and strlen(trim(parse_url($product->repo)['path'], '/')) !== 0)
                    <a class="list-group-item link-dark" href="{{ $product->repo }}" target="_blank" rel="noreferrer">
                        @if (parse_url($product->repo)['host'] === 'github.com')
                            <img class="brand-icon github-logo" src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" loading=lazy />
                        @elseif (parse_url($product->repo)['host'] === 'gitlab.com')
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/gitlab_j_ySNAHxP.svg" loading=lazy />
                        @elseif (parse_url($product->repo)['host'] === 'bitbucket.org')
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/bitbucket_f5ZE6ZhmF.svg" loading=lazy />
                        @endif
                        {{ trim(parse_url($product->repo)['path'], '/') }}
                    </a>
                @endif
            </ul>
        </div>
    @endif
    @if ($product->sponsor)
        <div class="text-uppercase fw-bold text-secondary pb-2">
            <x-heroicon-o-heart class="heroicon text-danger" />
            Sponsor
        </div>
        <div class="mb-4">
            <a class="btn w-100 btn-outline-primary" href="{{ $product->sponsor }}" target="_blank" rel="noreferrer">
                <img loading=lazy class="rounded sponsor-icon me-1" rel="preload" src="https://favicon.splitbee.io/?url={{ parse_url($product->sponsor)['host'] }}" />
                <span class="fw-bold">Sponsor {{ $product->name }}</span>
            </a>
        </div>
    @endif
    <div class="text-uppercase fw-bold text-secondary pb-2">
        Team
    </div>
    <div class="card mb-4">
        <div class="pt-2 pb-2">
            <div class="py-2 px-3">
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="user-popover"
                    data-id="{{ $product->owner->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($product->owner->avatar, 80) }}" height="30" width="30" alt="{{ $product->owner->username }}'s avatar" />
                </a>
                <a
                    href="{{ route('user.done', ['username' => $product->owner->username]) }}"
                    class="ms-2 align-middle fw-bold text-dark user-popover"
                    data-id="{{ $product->owner->id }}"
                >
                    @if ($product->owner->firstname or $product->owner->lastname)
                        {{ $product->owner->firstname }}{{ ' '.$product->owner->lastname }}
                    @else
                        {{ $product->owner->username }}
                    @endif
                    @if ($product->owner->status)
                    <span class="ms-1 small" title="{{ $product->owner->status }}">{{ $product->owner->status_emoji }}</span>
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
    @auth
        @if ($product->members->contains(auth()->user()->id))
            @livewire('product.leave', [
                'product' => $product,
            ])
        @endif
    @endauth
    <x-footer />
</div>
