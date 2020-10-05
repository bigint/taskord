<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card mx-auto">
        <a href="#url"><img class="card-img-top" src="{{ $meetup->cover }}" alt="Sample Title"></a>
        <div class="card-body">
            <div>
                Time
            </div>
            <h4 class="card-title">
                <a href="#url">{{ $meetup->name }}</a>
            </h4>
            <div>
                {{ $meetup->description }}
            </div>
        </div>
    </div>
</div>
