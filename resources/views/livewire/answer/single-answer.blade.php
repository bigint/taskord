<div class="card">
    <div class="card-body">
        <div class="align-items-center justify-content-between d-flex mb-2">
            <x:shared.user-label-small :user="$answer->user" />
            <div class="text-secondary small">
                @if ($answer->created_at < $answer->updated_at)
                    <span title="Edited {{ carbon($answer->updated_at)->diffForHumans() }}">Edited</span>
                    <span class="mx-1">•</span>
                @endif
                <a class="align-text-top float-end ms-auto text-secondary" href="">
                    {{ carbon($answer->created_at)->diffForHumans() }}
                </a>
            </div>
        </div>
        @if ($answer->hidden)
            <span class="body-font fst-italic text-secondary">Answer was hidden by moderator</span>
        @else
            @if ($edit)
                <div class="my-3">
                    <livewire:answer.edit-answer :answer="$answer" />
                </div>
            @else
                <span class="body-font">
                    {!! markdown($answer->answer) !!}
                </span>
            @endif
        @endif
        <div class="mt-2">
            @auth
                <x:like-button :entity="$answer" />
                <button class="btn btn-action btn-outline-primary me-1" wire:click="toggleReplyBox">
                    <x-heroicon-o-chat-alt class="heroicon heroicon-15px me-0 text-secondary" />
                    @if ($answer->replies()->count('id') !== 0)
                        <span class="small text-dark fw-bold">
                            {{ number_format($answer->replies()->count('id')) }}
                        </span>
                    @endif
                </button>
                @can('edit/delete', $answer)
                    <button type="button" class="btn btn-action btn-outline-primary me-1" wire:click="editAnswer"
                        wire:loading.attr="disabled" aria-label="Edit">
                        <x-heroicon-o-pencil class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                    <button type="button" class="btn btn-action btn-outline-danger"
                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteAnswer"
                        wire:loading.attr="disabled" aria-label="Delete">
                        <x-heroicon-o-trash class="heroicon heroicon-15px me-0 text-secondary" />
                    </button>
                @endcan
                @can('staff.ops')
                    <button type="button" class="btn btn-action {{ $answer->hidden ? 'btn-info' : 'btn-outline-info' }} ms-1"
                        wire:click="hide" wire:loading.attr="disabled" wire:key="{{ $answer->id }}" aria-label="Hide">
                        <x-heroicon-o-eye-off class="heroicon heroicon-15px me-0" />
                    </button>
                @endcan
            @endauth
            @guest
                <a href="/login" class="btn btn-action btn-outline-like me-1" aria-label="Likes">
                    <x-heroicon-o-heart class="heroicon heroicon-15px me-0" />
                    @if ($answer->likerscount() !== 0)
                        <span class="small fw-bold">
                            {{ number_format($answer->likerscount()) }}
                        </span>
                    @endif
                </a>
            @endguest
        </div>
    </div>
    <div class="bg-light rounded-bottom {{ $answer->replies()->count('id') > 0 ? 'border-1 border-top' : '' }}">
        <div class="px-3">
            <livewire:answer.reply.replies :answer="$answer" />
        </div>
        @auth
            @if ($showReplyBox)
                <div class="px-3 pb-3">
                    <livewire:answer.reply.create-reply :answer="$answer" />
                </div>
            @else
                <div class="p-2 border-1 border-top d-flex align-items-center">
                    <a href="{{ route('user.done', ['username' => auth()->user()->username]) }}" class="user-popover ms-2"
                        data-id="{{ auth()->id() }}">
                        <img loading=lazy class="avatar-25 rounded-circle"
                            src="{{ Helper::getCDNImage(auth()->user()->avatar, 80) }}" height="40" width="40"
                            alt="{{ auth()->user()->username }}'s avatar" />
                    </a>
                    <div class="ms-2 w-100 btn btn-sm border-1 border-reply text-dark text-start bg-white"
                        wire:click="toggleReplyBox">
                        Reply now
                    </div>
                </div>
                <div wire:loading wire:target="toggleReplyBox">
                    <div class="spinner-border spinner-border-sm taskord-spinner text-secondary m-3" role="status"></div>
                </div>
            @endif
        @endauth
    </div>
</div>
