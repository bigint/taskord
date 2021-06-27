<div class="card {{ $answer->replies()->count('id') > 0 ? '' : 'mt-3' }}">
    <div x-data="{ tab: 'edit' }">
        <div class="pt-2 rounded-top bg-light">
            <ul class="nav nav-tabs d-flex justify-content-between px-3">
                <div class="d-flex">
                    <li class="nav-item">
                        <div class="cursor-pointer nav-link active" :class="{ 'bg-white active': tab === 'edit' }"
                            x-on:click="tab = 'edit'">Edit</div>
                    </li>
                    <li class="nav-item">
                        <div class="cursor-pointer nav-link" :class="{ 'active bg-white': tab === 'preview' }"
                            x-on:click="tab = 'preview'">Preview</div>
                    </li>
                </div>
                <div x-show="tab === 'edit'" class="pt-1">
                    <x:markdown-toolbar htmlFor="reply-box-{{ $answer->id }}" />
                </div>
            </ul>
        </div>
        <div class="card-body">
            @error('reply')
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
                    <x-heroicon-o-exclamation class="heroicon" />
                    {{ $message }}
                </div>
            @enderror
            <div class="mb-2">
                <textarea x-show="tab === 'edit'" placeholder="Leave a reply" id="reply-box-{{ $answer->id }}"
                    class="form-control mentionInput" rows="3" wire:model.lazy="reply"></textarea>
                <div x-show="tab === 'preview'">
                    <div wire:loading>
                        Loading preview...
                    </div>
                    <div wire:loading.remove>
                        @if ($reply)
                            {!! markdown($reply) !!}
                        @else
                            Nothing to preview...
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a class="small fw-bold text-secondary" href="https://guides.github.com/features/mastering-markdown"
                    target="_blank">
                    <x-heroicon-o-pencil-alt class="heroicon" />
                    Markdown is supported
                    <x:labels.beta />
                </a>
                <button wire:loading.attr="disabled" wire:target="submit"
                    class="btn btn-sm btn-outline-primary rounded-pill" type="submit" wire:click="submit"
                    x-on:click="tab = 'edit'">
                    <x-heroicon-o-plus class="heroicon heroicon-15px" />
                    Reply
                </button>
            </div>
        </div>
    </div>
</div>
