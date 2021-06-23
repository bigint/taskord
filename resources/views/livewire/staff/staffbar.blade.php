<div class="card p-1 rounded-0 d-flex border-bottom border-staffbar bg-staffbar text-white">
    <div class="ps-2 pe-2">
        <span class="float-start">
            <span class="fw-bold">
                <x-heroicon-o-terminal class="heroicon me-1" />
                <a class="text-white" href="https://gitlab.com/taskord/taskord/-/tree/{{ $branch_name }}"
                    target="_blank" rel="noreferrer">{{ $branch_name }}</a>
                <x-heroicon-s-arrow-sm-right class="heroicon mx-0" />
                <a class="text-white" href="https://gitlab.com/taskord/taskord/-/commit/{{ $head_ref }}"
                    target="_blank" rel="noreferrer">{{ Str::limit($head_ref, 8, '') }}</a>
            </span>
            <a class="text-white-50 ms-3 d-none d-md-inline"
                href="https://github.com/laravel/framework/releases/tag/v{{ $laravel_version }}" target="_blank"
                rel="noreferrer">
                <x-heroicon-o-chip class="heroicon" />
                Laravel {{ $laravel_version }}.<span class="fw-bold">{{ $laravel_ref }}</span>
            </a>
        </span>
        <span class="float-end">
            @php
                $response = bcmul(microtime(true) - LARAVEL_START, '1000', 0);
            @endphp
            <span
                class="fw-bold me-3 border rounded-pill px-1 cursor-pointer {{ $response >= 200 ? 'border-warning' : 'border-success' }}"
                title="Response total">
                <span>{{ $response >= 200 ? '🐢' : '⚡️' }}</span>
                <span>{{ $response }}ms</span>
            </span>
            <span id="staffbar-stats" class="d-none">
                <a class="fw-bold me-3 text-white" href="/stafftools/horizon" title="Pending jobs" target="_blank"
                    rel="noreferrer">
                    <x-heroicon-o-collection class="heroicon" />
                    {{ $jobs }}
                    <span class="fw-normal text-white-50">
                        {{ pluralize('job', (int) $jobs) }}
                    </span>
                </a>
                <span class="fw-bold me-3" title="Memory usage">
                    <x-heroicon-o-cog class="heroicon" />
                    {{ memory_usage() }}
                </span>
                <span class="fw-bold me-3">
                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#cleanModal" title="Clear Cache">
                        <x-heroicon-o-trash class="heroicon text-white" />
                    </a>
                </span>
                <span class="fw-bold me-3">
                    <a class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#deployModal" title="Deploy">
                        <x-heroicon-o-cloud class="heroicon text-white" />
                    </a>
                </span>
            </span>
            <span class="fw-bold me-3">
                <a class="cursor-pointer" id="expand-stats">
                    <x-heroicon-o-menu class="heroicon text-white" />
                </a>
            </span>
            <span class="fw-bold">
                <a href="{{ route('staff.stats') }}" title="Stafftool">
                    <x-heroicon-s-shield-check class="heroicon text-white" />
                </a>
            </span>
        </span>
    </div>
    @include('livewire.staff.modals.clean')
    @include('livewire.staff.modals.deploy')
</div>
