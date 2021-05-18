<div class="p-3">
    <a class="fw-bold text-dark" href="{{ route('milestones.milestone', ['milestone' => $milestone]) }}">
        {{ Str::words($milestone->name, '10') }}
    </a>
    @if ($milestone->description)
        <div class="mt-2 body-font text-secondary">
            {!! Str::words(markdown($milestone->description), '20') !!}
        </div>
    @endif
    @if ($milestone->start_date or $milestone->end_date)
        @if ($milestone->start_date)
            <div class="mt-3 mb-1">
                <x-heroicon-o-calendar class="heroicon heroicon-18px" />
                Started at <b class="text-dark">{{ carbon($milestone->start_date)->format('M d, Y') }}</b>
            </div>
        @endif
        @if ($milestone->end_date)
            <div>
                @php
                    $past_due = $milestone->end_date < carbon();
                @endphp
                @if ($past_due)
                    <div class="text-danger">
                        <x-heroicon-o-exclamation class="heroicon heroicon-18px" />
                        Past due by <b>{{ carbon($milestone->end_date)->format('M d, Y') }}</b>
                    </div>
                @else
                    <div class="text-dark">
                        <x-heroicon-o-calendar class="heroicon heroicon-18px" />
                        Due by <b>{{ carbon($milestone->end_date)->format('M d, Y') }}</b>
                    </div>
                @endif
            </div>
        @endif
    @endif
    <div class="mt-3">
        <x:shared.user-label-small :user="$milestone->user" />
    </div>
</div>
