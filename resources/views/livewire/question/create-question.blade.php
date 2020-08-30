<div wire:ignore.self class="modal" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    @include('components.alert')
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Ask and discuss!" wire:model.lazy="title">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror" rows="6" placeholder="What's on your mind?" wire:model.lazy="body"></textarea>
                        @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if ($body)
                    <div>
                        <div class="h6 font-weight-bold mb-3">
                            <i class="fab fa-markdown mr-1"></i>
                            Markdown Preview
                        </div>
                        <span class="task-font">@markdown($body)</span>
                    </div>
                    @else
                    <div class="h6 font-weight-bold mb-3">
                        <i class="fab fa-markdown mr-1"></i>
                        Markdown is supported
                    </div>
                    @endif
                    @auth
                    @if (Auth::user()->isPatron)
                    <div class="mb-3">
                        <div class="font-weight-bold mb-2">Patron only</div>
                        <input id="patronOnly" class="form-check-input" type="checkbox" wire:model.lazy="patronOnly">
                        <label for="patronOnly" class="ml-1">This question will visible only for patrons</label>
                    </div>
                    @else
                    <div class="mb-2">
                        <a class="text-primary" href="{{ route('patron.home') }}" data-turbolinks="false">
                            {{ Emoji::redHeart() }} Support Taskord to post patron only questions!
                        </a>
                    </div>
                    @endif
                    @endauth
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Ask
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
