<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-tag class="heroicon heroicon-20px" />
        <span class="ms-1">Create new badge</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name of the badge</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        placeholder="Digital nomad" wire:model.defer="title">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Select your badge color</label>
                    <div class="d-flex">
                        <div class="form-check">
                            <input class="form-check-input p-3" type="radio" value="ff7474" wire:model.defer="color"
                                style="background: #ff7474">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff845d" wire:model.defer="color"
                                style="background: #ff845d">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="fd9a00" wire:model.defer="color"
                                style="background: #fd9a00">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="00b85c" wire:model.defer="color"
                                style="background: #00b85c">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="37c5ab" wire:model.defer="color"
                                style="background: #37c5ab">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="328aff" wire:model.defer="color"
                                style="background: #328aff">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="5f6ceb" wire:model.defer="color"
                                style="background: #5f6ceb">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="894cff" wire:model.defer="color"
                                style="background: #894cff">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff68d4" wire:model.defer="color"
                                style="background: #ff68d4">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff7474" wire:model.defer="color"
                                style="background: #ff7474">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff5381" wire:model.defer="color"
                                style="background: #ff5381">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="fb4e4e" wire:model.defer="color"
                                style="background: #fb4e4e">
                        </div>
                    </div>
                    @error('color')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Icon URL</label>
                    <input type="text" class="form-control @error('icon') is-invalid @enderror"
                        placeholder="https://example.com/icon.svg" wire:model.defer="icon">
                    @error('icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Create Badge
                </button>
            </div>
        </form>
    </div>
</div>
