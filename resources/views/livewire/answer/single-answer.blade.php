<div class="card-body">
    <div class="align-items-center d-flex mb-2">
        <x:shared.user-label-small :user="$answer->user" />
        <span class="align-text-top small float-end ms-auto">
            <a class="text-secondary" href="">
                {{ carbon($answer->created_at)->diffForHumans() }}
            </a>
        </span>
    </div>
    @if ($answer->hidden)
        <span class="body-font fst-italic text-secondary">Answer was hidden by moderator</span>
    @else
        @if ($edit)
            <div class="mt-3">
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
        @endauth
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
