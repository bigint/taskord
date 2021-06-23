<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-question-mark-circle class="heroicon heroicon-20px" />
        <span class="ms-1">Edit question</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        placeholder="Ask and discuss!" wire:model.defer="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Body</label>
                    <div>
                        <x:markdown-toolbar htmlFor="question-box" />
                    </div>
                    <textarea id="question-box"
                        class="form-control @error('body') is-invalid @enderror mentionInput mt-3" rows="6"
                        placeholder="What's on your mind?" wire:model.lazy="body"></textarea>
                    @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <a class="small fw-bold text-secondary mt-3"
                        href="https://guides.github.com/features/mastering-markdown" target="_blank">
                        <x-heroicon-o-pencil-alt class="heroicon" />
                        Markdown is supported
                        <x:labels.beta />
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Tags <span class="fw-normal text-secondary">- Use <i>ctrl</i> to multi select</span>
                    </label>
                    <select class="form-select @error('tags') is-invalid @enderror" multiple wire:model="selectedTags">
                        @foreach (Conner\Tagging\Model\Tag::get() as $tag)
                            <option class="font-monospace p-1" value="{{ $tag->name }}">
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-2 d-flex align-items-center">
                        <x-heroicon-s-check-circle class="heroicon-18px text-success" />
                        <span class="ms-1">Solvable</span>
                    </div>
                    <input id="solvable" class="form-check-input" type="checkbox" wire:model.defer="solvable">
                    <label for="solvable" class="ms-1">This question will enable you to solve the question</label>
                </div>
                @auth
                    @if (auth()->user()->is_patron)
                        <div class="mb-3">
                            <div class="fw-bold mb-2 d-flex align-items-center">
                                <x-heroicon-s-star class="heroicon-18px text-gold" />
                                <span class="ms-1">Patron only</span>
                            </div>
                            <input id="patronOnly" class="form-check-input" type="checkbox" wire:model.defer="patronOnly">
                            <label for="patronOnly" class="ms-1">This question will visible only for patrons</label>
                        </div>
                    @else
                        <div class="mb-2">
                            <a class="text-primary" href="{{ route('patron.home') }}">
                                ❤ Support Taskord to post patron only questions!
                            </a>
                        </div>
                    @endif
                @endauth
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
