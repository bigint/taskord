<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="h5 pt-3 pb-3 text-success card-header">
                <i class="fa fa-question mr-1"></i>
                Edit Question
            </div>
            <div class="card-body">
                @include('components.alert')
                <form wire:target="submit" wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Title</label>
                        <input type="text" value="{{ $title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Ask and discuss!" wire:model="title">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror" rows="6" placeholder="What's on your mind?" wire:model="body">{{ $body }}</textarea>
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
