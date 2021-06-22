<div>
    <div class="card mt-3 mb-2 w-75">
        <div class="{{ $oembed->type !== 'summary_large_image' ? 'd-flex align-items-center' : '' }}">
            @if ($oembed->thumbnail_url)
                @if ($oembed->type === 'summary_large_image')
                    <img class="card-img-top" src="{{ $oembed->thumbnail_url }}" alt="{{ $oembed->title }}">
                @else
                    <img class="rounded-start w-20" src="{{ $oembed->thumbnail_url }}" alt="{{ $oembed->title }}">
                @endif
            @endif
            <div class="card-body">
                <a href="{{ $oembed->url }}">
                    <div class="fw-bold text-dark">
                        {{ $oembed->title }}
                    </div>
                    <div class="mt-1 text-dark">
                        {{ $oembed->description }}
                    </div>
                </a>
                <div class="mt-1 d-flex align-items-center">
                    <img src="{{ $oembed->favicon }}" height="15" width="15" />
                    <a class="ms-2 text-secondary" href="{{ $oembed->provider_url }}" target="_blank">
                        {{ $oembed->provider_name }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
