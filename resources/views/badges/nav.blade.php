<div class="mb-3 d-flex align-items-center justify-content-between">
    <h5>
        Explore Badges
    </h5>
    @can('staff.ops')
        <a type="button" class="mb-2 btn btn-outline-success rounded-pill" href="{{ route('badges.new') }}">
            <x-heroicon-o-plus class="heroicon" />
            Add new badge
        </a>
    @endcan
</div>
