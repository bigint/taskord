<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-tag class="heroicon heroicon-20px" />
        <span class="ms-1">Edit badge</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <div class="fw-bold">Preview</div>
                    <div class="mt-2">
                        <div class="d-flex align-items-center">
                            <div class="card d-inline-block" style="background: #{{ $color }}">
                                <div class="p-4">
                                    @if ($icon)
                                        <img class="avatar-40" src="{{ $icon }}" />
                                    @else
                                        <img class="avatar-40"
                                            src="https://ik.imagekit.io/taskordimg/badges/placeholder.png" />
                                    @endif
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="h5 text-dark">
                                    @if ($title)
                                        {{ $title }}
                                    @else
                                        <span class="text-secondary">Title</span>
                                    @endif
                                </div>
                                <div class="text-secondary small mb-2">Created by {{ '@' . auth()->user()->username }}
                                </div>
                                <div class="text-secondary">
                                    <span class="fw-bold">1234</span> people have this
                                    badge
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Name of the badge</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        placeholder="Digital nomad" wire:model="title">
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
                            <input class="form-check-input p-3" type="radio" value="ff7474" wire:model="color"
                                style="background: #ff7474">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff845d" wire:model="color"
                                style="background: #ff845d">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="fd9a00" wire:model="color"
                                style="background: #fd9a00">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="00b85c" wire:model="color"
                                style="background: #00b85c">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="37c5ab" wire:model="color"
                                style="background: #37c5ab">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="328aff" wire:model="color"
                                style="background: #328aff">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="5f6ceb" wire:model="color"
                                style="background: #5f6ceb">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="894cff" wire:model="color"
                                style="background: #894cff">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff68d4" wire:model="color"
                                style="background: #ff68d4">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff7474" wire:model="color"
                                style="background: #ff7474">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="ff5381" wire:model="color"
                                style="background: #ff5381">
                        </div>
                        <div class="form-check ms-2">
                            <input class="form-check-input p-3" type="radio" value="fb4e4e" wire:model="color"
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
                        placeholder="https://example.com/icon.svg" wire:model="icon">
                    @error('icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Edit Badge
                </button>
            </div>
        </form>
    </div>
</div>
