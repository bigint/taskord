<div class="card mt-3 mb-2 w-75 bg-oembed">
    <div class="{{ $oembed->type !== 'summary_large_image' ? 'd-flex align-items-center' : '' }}">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <div class="d-flex align-items-center mb-1">
                    <img src="{{ Helper::getCDNImage($oembed->favicon, 20) }}" height="15" width="15" />
                    <a class="ms-2 text-secondary" href="{{ $oembed->provider_url }}" target="_blank">
                        {{ $oembed->provider_name }}
                    </a>
                </div>
                <a href="{{ $oembed->url }}" target="_blank">
                    <div class="fw-bold text-dark">
                        {{ $oembed->title }}
                    </div>
                    <div class="mt-1 text-dark">
                        {{ $oembed->description }}
                    </div>
                </a>
                @if ($oembed->thumbnail_url)
                    @if ($oembed->type === 'summary_large_image')
                        <img class="rounded border w-100 mt-3" src="{{ Helper::getCDNImage($oembed->thumbnail_url) }}"
                            alt="{{ $oembed->title }}">
                    @endif
                @endif
            </div>
            @if ($oembed->thumbnail_url)
                @if ($oembed->type !== 'summary_large_image')
                    <img class="rounded border w-20 ms-4" src="{{ Helper::getCDNImage($oembed->thumbnail_url) }}"
                        alt="{{ $oembed->title }}">
                @endif
            @endif
        </div>
    </div>
</div>
