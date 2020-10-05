<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card mx-auto">
        <a href="#url"><img class="card-img-top" src="{{ $meetup->cover }}" alt="Sample Title"></a>
        <div class="card-body">
            <div>
                {{ Carbon::parse($meetup->starts_at)->format('D, M d, H:i') }}
            </div>
            <h5 class="card-title">
                <a href="#url">{{ $meetup->name }}</a>
            </h5>
            <div>
                {{ $meetup->tagline }}
            </div>
        </div>
    </div>
</div>
