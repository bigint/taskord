<div class="mb-3">
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'milestones.opened' ? '' : 'outline-' }}primary me-2" href="{{ route('milestones.opened') }}">
        Opened
    </a>
    <a class="mb-2 btn btn-{{ Route::currentRouteName() === 'milestones.closed' ? '' : 'outline-' }}primary me-2" href="{{ route('milestones.closed') }}">
        Closed
    </a>
    @auth
    <button type="button" class="mb-2 btn btn-success float-md-end text-white" data-bs-toggle="modal" data-bs-target="#newMilestoneModal">
        <x-heroicon-o-plus class="heroicon" />
        Create a milestone
    </button>
    @livewire('milestone.create-milestone')
    @endauth
</div>
