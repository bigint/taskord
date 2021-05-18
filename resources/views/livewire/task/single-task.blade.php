<span>
    <div class="align-items-center d-flex">
        <x:shared.user-label-big :user="$task->user" />
        <span class="d-flex align-items-center small float-end ms-auto text-secondary cursor-pointer" data-bs-toggle="collapse" data-bs-target="#taskExpand-{{$task->id}}" aria-expanded="false">
            @if ($task->source === 'GitLab')
                <img class="task-icon me-2" src="https://ik.imagekit.io/taskordimg/icons/gitlab_j_ySNAHxP.svg" alt="GitHub Icon" />
            @elseif ($task->source === 'GitHub')
                <img class="task-icon github-logo me-2" src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" alt="GitLab Icon" />
            @endif
            {{ !$task->done_at ? $task->created_at->diffForHumans() : carbon($task->done_at)->diffForHumans() }}
        </span>
    </div>
    <div class="pt-3">
        @if ($task->hidden)
            <span class="fst-italic text-secondary">Task was hidden by moderator</span>
        @else
            <div class="form-check">
                <input
                    class="form-check-input task-check"
                    id="task-{{ $task->id }}"
                    type="checkbox"
                    wire:click="checkTask"
                    {{ $task->done ? "checked" : "unchecked" }}
                    {{
                        auth()->check() &&
                        auth()->user()->id === $task->user_id ?
                        "enabled" : "disabled"
                    }}
                />
                @if ($launched)<span class="ms-2">🚀</span>@endif
                <label for="task-{{ $task->id }}" class="task-font ms-2 {{ $launched ? 'fw-bold text-success' : 'text-dark' }}">
                    {!! clean(Helper::renderTask($task->task)) !!}
                    @if ($task->type === 'product')
                        <span class="small text-secondary ms-1">
                            <img loading=lazy class="rounded mb-1 avatar-15" src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15" alt="{{ $task->product->slug }}'s avatar" />
                            <a
                                class="text-secondary product-popover fw-bold"
                                href="{{ route('product.done', ['slug' => $task->product->slug]) }}"
                                data-id="{{ $task->product->id }}"
                            >
                                {{ $task->product->name }}
                            </a>
                        </span>
                    @endif
                </label>
            </div>
            @if ($task->images)
                <div class="gallery">
                    @foreach ($task->images ?? [] as $image)
                        <div>
                            <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                <img loading=lazy class="gallery img-fluid mt-3 rounded" src="{{ Helper::getCDNImage(asset('storage/' . $image), 500) }}" alt="{{ asset('storage/' . $image) }}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
        @if ($task->milestone)
            <div class="mt-2">
                <a
                    class="text-secondary milestone-popover"
                    href="{{ route('milestones.milestone', ['milestone' => $task->milestone]) }}"
                    data-id="{{ $task->milestone->id }}"
                >
                    <x-heroicon-o-truck class="heroicon me-1" />
                    <span>{{ $task->milestone->name }}</span>
                </a>
            </div>
        @endif
        <div class="pt-2">
            @auth
                @if (!$task->user->isPrivate and !$task->hidden)
                    @if (auth()->user()->hasLiked($task))
                        <button type="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" aria-label="Praises">
                            <x-heroicon-s-thumb-up class="heroicon heroicon-15px me-0" />
                            <span class="small text-white fw-bold">
                                {{ number_format($task->likerscount()) }}
                            </span>
                            <span class="avatar-stack ms-1">
                                @foreach($task->likers->take(5) as $user)
                                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                @endforeach
                            </span>
                        </button>
                    @else
                        <button type="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" aria-label="Praises">
                            <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0 text-secondary" />
                            @if ($task->likerscount() !== 0)
                                <span class="small text-dark fw-bold">
                                    {{ number_format($task->likerscount()) }}
                                </span>
                                <span class="avatar-stack ms-1">
                                    @foreach($task->likers->take(5) as $user)
                                        <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                                    @endforeach
                                </span>
                            @endif
                        </button>
                    @endif
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1" aria-label="Praises">
                    <x-heroicon-o-thumb-up class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($task->likerscount() !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($task->likerscount()) }}
                        </span>
                        <span class="avatar-stack ms-1">
                            @foreach($task->likers->take(5) as $user)
                                <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="15" width="15" alt="{{ $user->username }}'s avatar" />
                            @endforeach
                        </span>
                    @endif
                </a>
            @endguest
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-task btn-outline-primary me-1" aria-label="Comments">
                <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                @if ($task->comments->count('id') !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($task->comments->count('id')) }}
                    </span>
                @endif
            </a>
            @auth
                @if (auth()->user()->staffShip or auth()->user()->id === $task->user->id)
                    <button
                        type="button"
                        class="btn btn-task btn-outline-danger me-1"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                        wire:click="deleteTask"
                        wire:loading.attr="disabled"
                        wire:offline.attr="disabled"
                        aria-label="Delete"
                    >
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                    @livewire('task.select-milestone', [
                        'task' => $task
                    ])
                @endif
                @if (auth()->user()->staffShip)
                    <button type="button" class="btn btn-task {{ $task->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $task->id }}" title="Flag to admins" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endif
            @endauth
        </div>
        @if (!$task->hidden)
            @if ($task->comments->count('id') !== 0 and $showComments)
                @livewire('task.comments', [
                    'task' => $task
                ])
            @endif
        @endif
    </div>
    <div class="collapse mt-3 text-secondary" id="taskExpand-{{$task->id}}">
        <a class="text-secondary" href="{{ route('task', ['id' => $task->id]) }}">
            <x-heroicon-o-calendar class="heroicon heroicon-15px" />
            @auth
                {{
                    !$task->done_at ?
                        carbon($task->created_at)
                            ->setTimezone(auth()->user()->timezone)
                            ->format('g:i A · M d, Y') :
                        carbon($task->done_at)
                            ->setTimezone(auth()->user()->timezone)
                            ->format('g:i A · M d, Y')
                }}
            @else
                {{
                    !$task->done_at ?
                        $task->created_at->format('g:i A · M d, Y') :
                        carbon($task->done_at)->format('g:i A · M d, Y')
                }}
            @endauth
            · via
            <span class="fw-bold">{{ $task->source }}</span>
        </a>
    </div>
</span>
