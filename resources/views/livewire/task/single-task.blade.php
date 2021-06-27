<span>
    <div class="align-items-start d-flex">
        <x:shared.user-label-big :user="$task->user" />
        <a class="d-flex align-items-center small float-end ms-auto text-secondary"
            href="{{ route('task', ['id' => $task->id]) }}">
            @if ($task->source === 'GitLab')
                <img class="task-icon me-2" src="https://ik.imagekit.io/taskordimg/icons/gitlab_j_ySNAHxP.svg"
                    alt="GitHub Icon" />
            @elseif ($task->source === 'GitHub')
                <img class="task-icon github-logo me-2"
                    src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" alt="GitLab Icon" />
            @endif
            {{ !$task->done_at ? carbon($task->created_at)->diffForHumans() : carbon($task->done_at)->diffForHumans() }}
        </a>
    </div>
    <div class="pt-3">
        @if ($task->hidden)
            <span class="fst-italic text-secondary">Task was hidden by moderator</span>
        @else
            <div class="form-check">
                <input class="form-check-input task-check" id="task-{{ $task->id }}" type="checkbox"
                    wire:click="checkTask" {{ $task->done ? 'checked' : 'unchecked' }}
                    {{ auth()->check() && auth()->user()->id === $task->user_id ? 'enabled' : 'disabled' }} />
                <label for="task-{{ $task->id }}"
                    class="task-font ms-2 {{ $launched ? 'fw-bold text-success' : 'text-dark' }}">
                    @if ($launched)<span class="mx-1 small">🚀</span>@endif
                    {!! clean(Helper::renderTask($task->task)) !!}
                    @if ($task->type === 'product')
                        <span class="small text-secondary ms-1">
                            <img loading=lazy class="rounded-2 mb-1 avatar-15"
                                src="{{ Helper::getCDNImage($task->product->avatar, 80) }}" height="15" width="15"
                                alt="{{ $task->product->slug }}'s avatar" />
                            <a class="text-secondary product-popover fw-bold"
                                href="{{ route('product.done', ['slug' => $task->product->slug]) }}"
                                data-id="{{ $task->product->id }}">
                                {{ $task->product->name }}
                            </a>
                        </span>
                    @endif
                </label>
            </div>
            @if ($task->images)
                <div class="row row-cols-2">
                    @foreach ($task->images ?? [] as $image)
                        <div class="col">
                            <div type="button" data-bs-toggle="modal" data-bs-target="#lightboxModal"
                                data-bs-whatever="{{ asset('storage/' . $image) }}">
                                <img loading=lazy class="img-fluid border mt-2 rounded"
                                    src="{{ Helper::getCDNImage(asset('storage/' . $image), 500) }}"
                                    alt="{{ asset('storage/' . $image) }}" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (feature('oembed'))
                @if ($task->oembed)
                    <livewire:task.oembed :oembed="$task->oembed" />
                @endif
            @endif
        @endif
        @if ($task->milestone)
            <div class="mt-2">
                <a class="text-secondary milestone-popover"
                    href="{{ route('milestones.milestone', ['milestone' => $task->milestone]) }}"
                    data-id="{{ $task->milestone->id }}">
                    <x-heroicon-o-truck class="heroicon me-1" />
                    <span>{{ $task->milestone->name }}</span>
                </a>
            </div>
        @endif
        <div class="pt-2">
            @auth
                @if (!$task->user->is_private and !$task->hidden)
                    <x:like-button :entity="$task" />
                @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($task->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($task->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
            <a href="{{ route('task', ['id' => $task->id]) }}" class="btn btn-action btn-outline-primary me-1"
                aria-label="Comments">
                <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                @if ($task->comments()->count('id') !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($task->comments()->count('id')) }}
                    </span>
                @endif
            </a>
            @can('edit/delete', $task)
                <button type="button" class="btn btn-action btn-outline-danger me-1"
                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteTask"
                    wire:loading.attr="disabled" aria-label="Delete">
                    <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                </button>
                <livewire:task.select-milestone :task="$task" />
            @endcan
            @can('staff.ops')
                <button type="button" class="btn btn-action {{ $task->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1"
                    wire:click="hide" wire:loading.attr="disabled" wire:key="{{ $task->id }}" aria-label="Hide">
                    <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                </button>
            @endcan
        </div>
        @if (!$task->hidden)
            @if ($task->comments->count('id') !== 0 and $showComments)
                @livewire('task.comments', [
                'task' => $task
                ])
            @endif
        @endif
    </div>
</span>
