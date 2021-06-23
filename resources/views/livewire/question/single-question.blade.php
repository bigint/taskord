<div class="card mb-2 {{ $question->patron_only ? 'bg-patron-question' : '' }}">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <x:shared.user-label-big :user="$question->user" />
            <span class="d-flex align-items-center small ms-auto">
                <div>
                    @if ($question->is_solvable)
                        @if ($question->solved)
                            <h6 class="m-0">
                                <span class="badge bg-success me-2">
                                    <x-heroicon-s-check-circle class="heroicon heroicon-15px" />
                                    <span>Solved</span>
                                </span>
                            </h6>
                        @else
                            <h6 class="m-0">
                                <span class="badge bg-secondary me-2 d-flex align-items-center">
                                    <x-heroicon-o-check-circle class="heroicon heroicon-15px" />
                                    <span>Unsolved</span>
                                </span>
                            </h6>
                        @endif
                    @endif
                </div>
                <a class="text-secondary" href="{{ route('question.question', ['slug' => $question->slug]) }}">
                    {{ carbon($question->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($question->hidden)
            <span class="fst-italic text-secondary">Question was hidden by moderator</span>
        @else
            <a href="{{ route('question.question', ['slug' => $question->slug]) }}"
                class="h5 align-text-top fw-bold text-dark">
                @if ($type !== 'question.question')
                    {{ Str::words($question->title, '10') }}
                @else
                    {{ $question->title }}
                @endif
            </a>
            <div class="mt-2 body-font">
                @if ($type !== 'question.question')
                    @if (!$question->patron_only)
                        {!! markdown(Str::words($question->body, '30')) !!}
                    @endif
                @else
                    {!! markdown($question->body) !!}
                @endif
            </div>
        @endif
        <div class="mt-3">
            @auth
                <x:like-button :entity="$question" />
                <a href="{{ route('question.question', ['slug' => $question->slug]) }}"
                    class="btn btn-action btn-outline-primary me-1" aria-label="Questions">
                    <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($question->answers->count('id') !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($question->answers->count('id')) }}
                        </span>
                    @endif
                </a>
            @endauth
            @can('edit/delete', $question)
                @if ($type === 'question.question')
                    <a href="{{ route('question.edit', ['slug' => $question->slug]) }}"
                        class="btn btn-action btn-outline-info me-1">
                        <x-heroicon-o-pencil-alt class="heroicon heroicon-15px me-0 text-secondary" />
                        <span class="small text-dark fw-bold">
                            Edit
                        </span>
                    </a>
                @endif
                <button role="button" class="btn btn-action btn-outline-danger me-1"
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteQuestion"
                    wire:loading.attr="disabled" aria-label="Delete">
                    <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                </button>
                @if ($question->is_solvable)
                    <button role="button" class="btn btn-action btn-outline-success me-1" wire:click="toggleSolve"
                        wire:loading.attr="disabled">
                        @if ($question->solved)
                            <x-heroicon-s-check-circle class="heroicon heroicon-15px me-0 text-success" />
                            Unsolve
                        @else
                            <x-heroicon-s-check-circle class="heroicon heroicon-15px me-0 text-success" />
                            Solve
                        @endif
                    </button>
                @endif
            @endcan
            @can('staff.ops')
                <button type="button" class="btn btn-action {{ $question->hidden ? 'btn-info' : 'btn-outline-info' }}"
                    wire:click="hide" wire:loading.attr="disabled" wire:key="{{ $question->id }}" aria-label="Hide">
                    <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                </button>
            @endcan
            @guest
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($question->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($question->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
            @if (views($question)->remember(now()->addHours(6))->count('id') > 0)
                <span class="align-middle ms-2 me-2">
                    <x-heroicon-o-eye class="heroicon" />
                    <span class="text-secondary">
                        @php
                            $views = views($question)
                                ->remember(now()->addHours(6))
                                ->unique()
                                ->count('id');
                        @endphp
                        <span class="fw-bold">{{ number_format($views) }}</span>
                        {{ pluralize('View', $views) }}
                    </span>
                </span>
            @endif
            @if ($type !== 'question.question')
                <a href="{{ route('question.question', ['slug' => $question->slug]) }}"
                    class="avatar-stack text-dark">
                    @foreach ($question->answers->groupBy('user_id')->take(5) as $answer)
                        <img loading=lazy class="user-popover rounded-circle avatar avatar-30"
                            data-id="{{ $answer[0]->user->id }}"
                            src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}" height="30" width="30"
                            alt="{{ $answer[0]->user->username }}'s avatar" />
                    @endforeach
                    @if ($question->answers->groupBy('user_id')->count('id') >= 5)
                        <span class="ms-3 ps-1 align-middle fw-bold small">
                            +{{ number_format($question->answers->groupBy('user_id')->count('id') - 5) }} more
                        </span>
                    @endif
                </a>
            @endif
        </div>
    </div>
</div>
