<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-truck class="heroicon heroicon-20px" />
        <span class="ms-1">Create new milestone</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Add new feature!" wire:model.defer="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror mentionInput" rows="6" placeholder="What's on your mind?" wire:model.defer="description"></textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="small fw-bold text-secondary mt-3 mb-3">
                        <x-heroicon-o-pencil-alt class="heroicon" />
                        Markdown is supported
                         <x:labels.beta />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Start Date</label>
                        <input class="form-control" wire:model="start_date" type="date" />
                    </div>
                    @if ($start_date)
                        <div class="mb-3">
                            <label class="form-label fw-bold">End Date</label>
                            <input class="form-control" wire:model="end_date" type="date" min="{{ carbon($start_date)->format('Y-m-d') }}" />
                        </div>
                    @else
                        <div class="fw-bold">Select from date to pick due date</div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
