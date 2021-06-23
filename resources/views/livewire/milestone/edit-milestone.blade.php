<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-truck class="heroicon heroicon-20px" />
        <span class="ms-1">Edit milestone</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Add new feature!" wire:model.defer="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <div>
                        <x:markdown-toolbar htmlFor="milestone-box" />
                    </div>
                    <textarea id="milestone-box"
                        class="form-control @error('description') is-invalid @enderror mentionInput mt-3" rows="6"
                        placeholder="What's on your mind?" wire:model.lazy="description"></textarea>
                    @error('description')
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
                    <div class="mb-3 mt-3">
                        <label class="form-label fw-bold">Start Date</label>
                        <input class="form-control" wire:model="startDate" type="date" />
                    </div>
                    @if ($startDate)
                        <div class="mb-3">
                            <label class="form-label fw-bold">End Date</label>
                            <input class="form-control" wire:model="endDate" type="date"
                                min="{{ carbon($startDate)->format('Y-m-d') }}" />
                        </div>
                    @else
                        <div class="fw-bold">Select from date to pick due date</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
