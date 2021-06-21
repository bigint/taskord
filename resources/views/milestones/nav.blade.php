<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::is('milestones.opened') ? '' : 'outline-' }}primary rounded-pill me-2" href="{{ route('milestones.opened') }}">
        Opened
    </a>
    <a class="mb-2 btn btn-{{ Route::is('milestones.closed') ? '' : 'outline-' }}primary rounded-pill me-2" href="{{ route('milestones.closed') }}">
        Closed
    </a>
    @auth
        <a href="{{ route('milestones.new') }}" class="mb-2 btn btn-success float-md-end text-white">
            <x-heroicon-o-plus class="heroicon" />
            Create a milestone
        </a>
    @endauth
</div>
