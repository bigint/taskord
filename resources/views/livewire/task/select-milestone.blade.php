<span class="dropdown">
    <button class="btn btn-action btn-outline-info dropdown-toggle" id="milestoneMenuItem" data-bs-toggle="dropdown"
        aria-expanded="false">
        <x-heroicon-o-truck class="heroicon heroicon-15px text-secondary" />
    </button>
    <ul class="dropdown-menu" aria-labelledby="milestoneMenuItem">
        @if ($task->milestone)
            <li>
                <a class="dropdown-item cursor-pointer" wire:click="noMilestone">
                    No milestone
                </a>
            </li>
            <div class="dropdown-divider"></div>
        @endif
        @foreach ($task->user->milestones()->whereStatus(true)->latest()->get() as $milestone)
            <li wire:key="{{ $task->id }}_{{ $milestone->id }}">
                <a class="dropdown-item cursor-pointer" wire:click="selectMilestone({{ $milestone }})">
                    <span class="text-secondary me-2 fw-bold">#{{ $milestone->id }}</span>
                    <span>{{ $milestone->name }}</span>
                </a>
            </li>
        @endforeach
        @if ($task->user->milestones()->whereStatus(true)->count() === 0)
            <li>
                <a class="dropdown-item cursor-pointer" href="{{ route('milestones.new') }}">
                    Create a milestone
                </a>
            </li>
        @endif
        <div class="dropdown-divider"></div>
        <li>
            <span class="p-2">
                <x:labels.beta />
            </span>
        </li>
    </ul>
</span>
