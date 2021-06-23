<div>
    <div class="h5 mb-3 text-secondary d-flex align-content-center">
        <x-heroicon-o-cube class="heroicon heroicon-20px" />
        <span class="ms-1">Create new product</span>
    </div>
    <div class="card">
        <form wire:target="submit" wire:submit.prevent="submit">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Name of the product</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Simply the name of the product" wire:model.defer="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                        placeholder="Product Slug (/taskord)" wire:model.defer="slug">
                    @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" rows="3"
                        placeholder="Some words about your awesome product" wire:model.defer="description"></textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Logo</label>
                    <div class="form-file w-50">
                        <input class="form-control form-control-sm" wire:model="avatar" type="file">
                    </div>
                </div>
                <div wire:loading wire:target="avatar">
                    <div class="spinner-border spinner-border-sm mb-3" role="status"></div>
                </div>
                @error('avatar')
                    <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                @else
                    @if ($avatar)
                        <div>
                            <img loading=lazy class="avatar-100 rounded mb-3" src="{{ $avatar->temporaryUrl() }}"
                                height="100" width="100" />
                        </div>
                    @endif
                @enderror
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <x-heroicon-o-link class="heroicon" />
                    </span>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" placeholder="Website"
                        wire:model.defer="website">
                    @error('website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg"
                            loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('twitter') is-invalid @enderror" placeholder="Twitter"
                        wire:model.defer="twitter">
                    @error('twitter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/producthunt_tzL4ouGeqn.svg"
                            loading=lazy />
                    </span>
                    <input type="text" class="form-control @error('producthunt') is-invalid @enderror"
                        placeholder="Product Hunt" wire:model.defer="producthunt">
                    @error('producthunt')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <x-heroicon-o-code class="heroicon" />
                    </span>
                    <input type="text" class="form-control @error('repo') is-invalid @enderror" placeholder="Repository"
                        wire:model.defer="repo">
                    @error('repo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <x-heroicon-o-heart class="heroicon text-danger" />
                    </span>
                    <input type="text" class="form-control @error('sponsor') is-invalid @enderror"
                        placeholder="Sponsor URL" wire:model.defer="sponsor">
                    @error('sponsor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="fw-bold mb-2">Status</div>
                    <div class="form-check">
                        <input id="launched" class="form-check-input" type="checkbox" wire:model.defer="launched">
                        <label for="launched" class="form-check-label">This product is launched</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary rounded-pill">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
