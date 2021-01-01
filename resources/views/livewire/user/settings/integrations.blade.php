<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Integrations</span>
            <div>Just send a POST event from anywhere</div>
        </div>
        <div class="card-body">
            <span class="h5">Create Webhook</span>
            <form wire:submit.prevent="submit">
                <div class="mb-3 mt-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" placeholder="Webhook Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (user()->ownedProducts->merge(user()->products)->count('id') > 0)
                    <select class="form-select mt-3" wire:model.defer="product">
                        <option selected>Choose Product (optional)</option>
                        @foreach (user()->ownedProducts->merge(user()->products) as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="mb-3 d-flex">
                    <span class="form-check">
                        <input class="form-check-input" type="radio" id="web" name="type" value="web" wire:model.defer="type" checked>
                        <label class="form-check-label" for="web">
                            Simple Webhook
                        </label>
                    </span>
                    <span class="form-check ms-3">
                        <input class="form-check-input" type="radio" id="github" name="type" value="github" wire:model.defer="type">
                        <label class="form-check-label" for="github">
                            GitHub
                        </label>
                    </span>
                    <span class="form-check ms-3">
                        <input class="form-check-input" type="radio" id="gitlab" name="type" value="gitlab" wire:model.defer="type">
                        <label class="form-check-label" for="gitlab">
                            GitLab
                        </label>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary">
                    Create Hook
                </button>
            </form>
            @if (session()->has('created'))
                <div class="mt-4">
                    <span class="h5">
                        Here's your webhook for Taskord. Keep it secret.
                    </span>
                    <div class="small text-secondary">Make sure you save it - you won't be able to access it again.</div>
                    <div class="fw-bold text-primary font-monospace mt-2">
                        https://taskord.com/webhook/web/{{ session('created')->token }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Webhook Docs</span>
            <div>Available webhook options</div>
        </div>
        <div class="card-body-flush">
            <div class="accordion accordion-flush" id="webhookDocs">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="simple-webhook">
                        <button class="accordion-button bg-light" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-simple-webhook" aria-expanded="true" aria-controls="collapse-simple-webhook">
                            <x-heroicon-o-globe-alt class="heroicon me-2" />
                            Simple Webhook
                        </button>
                    </h2>
                    <div id="collapse-simple-webhook" class="accordion-collapse collapse show"
                        aria-labelledby="simple-webhook" data-bs-parent="#webhookDocs">
                        <div class="accordion-body">
                            <table class="table table-bordered mb-0 align-middle text-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">Parameter</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Required</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>task</td>
                                        <td>String</td>
                                        <td>Yes</td>
                                        <td>The body of the task</td>
                                    </tr>
                                    <tr>
                                        <td>done</td>
                                        <td>Boolean</td>
                                        <td>Yes</td>
                                        <td>Is it a completed task?</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="github-webhook">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-github-webhook" aria-expanded="false" aria-controls="collapse-github-webhook">
                            <img class="me-2 github-logo" src="{{ asset('images/brand/github.svg') }}" height="15" width="15" />
                            GitHub
                        </button>
                    </h2>
                    <div id="collapse-github-webhook" class="accordion-collapse collapse" aria-labelledby="github-webhook"
                        data-bs-parent="#webhookDocs">
                        <div class="accordion-body">
                            <ol class="mb-0">
                                <li>Go to repository settings</li>
                                <li>Click "Add webhook" button</li>
                                <li>In "Payload URL" paste the URL generated below</li>
                                <li>In "Content type" select "application/json"</li>
                                <li>Select only the push event</li>
                                <li>Click "Add webhook" button to save</li>
                                <li>Voila! 🎉</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="gitlab-webhook">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-gitlab-webhook" aria-expanded="false"
                            aria-controls="collapse-gitlab-webhook">
                            <img class="me-2" src="{{ asset('images/brand/gitlab.svg') }}" height="15" width="15" />
                            GitLab
                        </button>
                    </h2>
                    <div id="collapse-gitlab-webhook" class="accordion-collapse collapse"
                        aria-labelledby="gitlab-webhook" data-bs-parent="#webhookDocs">
                        <div class="accordion-body">
                            <ol class="mb-0">
                                <li>Go to Settings ➜ Webhooks</li>
                                <li>In "URL" paste the URL generated below</li>
                                <li>Click "Add webhook" button to save</li>
                                <li>Voila! 🎉</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Active webhooks</span>
            <div>Webhooks that are active</div>
        </div>
        <div class="card-body">
            @if (count($user->webhooks) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-globe-alt class="heroicon-4x text-primary mb-2" />
                <div class="h4">
                    No webhooks found
                </div>
            </div>
            @else
            <table class="table table-bordered align-middle text-dark">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Name</th>
                        <th scope="col">Token</th>
                        <th scope="col">Created</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->webhooks as $webhook)
                    <tr>
                        <td>
                            @if ($webhook->type === 'web')
                            <span title="Simple Webhook | ID: {{ $webhook->id }}">
                                <x-heroicon-o-globe-alt class="heroicon text-info" />
                            </span>
                            @elseif ($webhook->type === 'github')
                            <img class="github-logo" src="{{ asset('images/brand/github.svg') }}" height="15" width="15" />
                            @elseif ($webhook->type === 'gitlab')
                            <img src="{{ asset('images/brand/gitlab.svg') }}" height="15" width="15" />
                            @endif
                        </td>
                        <td class="fw-bold">
                            {{ Str::limit($webhook->name, '20') }}
                        </td>
                        <td class="font-monospace">
                            {{ Str::limit($webhook->token, '4', '****************') }}
                        </td>
                        <td>
                            {{ $webhook->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            <button wire:loading.attr="disabled" wire:click="deleteWebhook({{ $webhook->id }})"
                                class="btn btn-sm w-100 btn-danger">
                                <x-heroicon-o-trash class="heroicon" />
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
