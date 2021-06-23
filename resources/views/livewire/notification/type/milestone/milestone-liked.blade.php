<div>
    @if ($milestone)
        <div class="mt-2 text-secondary">
            liked your
            <a class="fw-bold" href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}">
                milestone
            </a>
        </div>
        <div class="mt-3">
            <livewire:milestone.single-milestone type="milestones.opened" :milestone="$milestone"
                :wire:key="$milestone->id" />
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
