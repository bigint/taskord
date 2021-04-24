<span class="dropdown">
    <a class="btn btn-task btn-outline-info dropdown-toggle" role="button" id="milestoneMenuItem" data-bs-toggle="dropdown" aria-expanded="false">
        <x-heroicon-o-truck class="heroicon-small text-secondary" />
    </a>
    <ul class="dropdown-menu" aria-labelledby="milestoneMenuItem">
        <li>
            <a class="dropdown-item cursor-pointer" wire:click="noMilestone">
                No milestone
            </a>
        </li>
        <div class="dropdown-divider"></div>
        @foreach ($milestones as $milestone)
            <li wire:key="{{ $task->id }}_{{ $milestone->id }}">
                <a class="dropdown-item cursor-pointer" wire:click="selectMilestone({{ $milestone }})">
                    <span class="text-secondary me-2 fw-bold">#{{ $milestone->id }}</span>
                    <span>{{ $milestone->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</span>
