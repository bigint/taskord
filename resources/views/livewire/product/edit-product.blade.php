<div wire:ignore.self class="modal" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:target="submit" wire:submit.prevent="submit">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name of the product</label>
                        <input type="text" value="{{ $name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Simply the name of the product" wire:model.defer="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text" value="{{ $slug }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Product Slug (/taskord)" wire:model.defer="slug">
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Some words about your awesome product" wire:model.defer="description">{{ $description }}</textarea>
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
                        <div class="spinner-border spinner-border-sm" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @error('avatar')
                    <div class="text-danger fw-bold mt-3">{{ $message }}</div>
                    @else
                    @if ($avatar)
                    <div>
                        <img loading=lazy class="avatar-100 rounded mb-3" src="{{ $avatar->temporaryUrl() }}">
                    </div>
                    @else
                    @if ($product->avatar)
                    <div>
                        <img loading=lazy class="avatar-100 rounded mb-3" src="{{ Helper::getCDNImage($product->avatar, 240) }}" alt="{{ $product->slug }}'s avatar" />
                    </div>
                    @endif
                    @endif
                    @enderror
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <x-heroicon-o-link class="heroicon" />
                        </span>
                        <input type="text" value="{{ $website }}" class="form-control @error('website') is-invalid @enderror" placeholder="Website" wire:model.defer="website">
                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <img class="brand-icon" src="{{ asset('images/brand/twitter.svg') }}" />
                        </span>
                        <input type="text" value="{{ $twitter }}" class="form-control @error('twitter') is-invalid @enderror" placeholder="Twitter" wire:model.defer="twitter">
                        @error('twitter')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <img class="brand-icon" src="{{ asset('images/brand/producthunt.svg') }}" />
                        </span>
                        <input type="text" value="{{ $producthunt }}" class="form-control @error('producthunt') is-invalid @enderror" placeholder="Product Hunt" wire:model.defer="producthunt">
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
                        <input type="text" value="{{ $repo }}" class="form-control @error('repo') is-invalid @enderror" placeholder="Repository" wire:model.defer="repo">
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
                        <input type="text" class="form-control @error('sponsor') is-invalid @enderror" placeholder="Sponsor URL" wire:model.defer="sponsor">
                        @error('sponsor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold mb-2">Status</div>
                        <input id="launched" class="form-check-input" type="checkbox" wire:model.defer="launched">
                        <label for="launched" class="ms-1">This product is launched</label>
                    </div>
                    <div class="mb-3">
                        <div class="fw-bold mb-2">Deprecated</div>
                        <input id="deprecated" class="form-check-input" type="checkbox" wire:model.defer="deprecated">
                        <label for="deprecated" class="ms-1">This product is no longer available</label>
                    </div>
                </div>
                <div class="modal-footer">
                    @if ($confirming === $product->id)
                    <button type="button" wire:click="deleteProduct" class="btn btn-danger">
                        <span class="fw-bold">Are you sure?</span>
                        <span wire:target="deleteProduct" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
                    </button>
                    @else
                    <button type="button" wire:click="confirmDelete" class="btn btn-danger">
                        <span class="fw-bold">Delete</span> {{ $slug }}
                    </button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Update
                        <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
