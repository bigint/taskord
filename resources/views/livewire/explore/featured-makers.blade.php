<div wire:init="loadFeaturedMakers">
    @if (!$readyToLoad)
        <x:loaders.featured-makers-skeleton count="3" />
    @else
        <ul class="list-group list-group-flush">
            @foreach ($users as $user)
                <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                    <div class="d-flex align-items-center">
                        <span class="small me-2 text-secondary">{{ $loop->index + 1 }}</span>
                        <x:shared.user-label-big :user="$user" />
                    </div>
                    <div class="d-flex">
                        @if ($user->sponsor)
                            <a class="btn btn-sm btn-outline-primary rounded-pill me-2" href="{{ $user->sponsor }}"
                                target="_blank" rel="noreferrer">
                                <img loading=lazy class="rounded sponsor-icon me-1" rel="preload"
                                    src="https://favicon.splitbee.io/?url={{ parse_url($user->sponsor)['host'] }}" />
                                <span>Sponsor <span class="fw-bold">{{ '@' . $user->username }}</span></span>
                            </a>
                        @endif
                        <livewire:notification.follow :user="$user" />
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
