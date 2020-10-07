<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Integrations</span>
            <div>Just send a POST event from anywhere</div>
        </div>
        <div class="card-body">
            <x-alert />
            <span class="h5">Create Webhook</span>
            <form wire:submit.prevent="submit">
                <div class="mb-3 mt-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" placeholder="Webhook Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (Auth::user()->ownedProducts->merge(Auth::user()->products)->count('id') > 0)
                    <select class="form-select mt-3" wire:model.defer="product">
                        <option selected>Choose Product (optional)</option>
                        @foreach (Auth::user()->ownedProducts->merge(Auth::user()->products) as $product)
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
                    <span class="form-check ml-3">
                        <input class="form-check-input" type="radio" id="github" name="type" value="github" wire:model.defer="type">
                        <label class="form-check-label" for="github">
                            GitHub
                        </label>
                    </span>
                    <span class="form-check ml-3">
                        <input class="form-check-input" type="radio" id="gitlab" name="type" value="gitlab" wire:model.defer="type">
                        <label class="form-check-label" for="gitlab">
                            GitLab
                        </label>
                    </span>
                </div>
                <button type="submit" class="btn btn-primary">
                    Create Hook
                    <span wire:target="submit" wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
                </button>
            </form>
            @if (session()->has('created'))
                <div class="mt-4">
                    <span class="h5">
                        Here's your webhook for Taskord. Keep it secret.
                    </span>
                    <div class="small text-black-50">Make sure you save it - you won't be able to access it again.</div>
                    <div class="font-weight-bold text-primary font-monospace mt-2">
                        https://taskord.com/webhook/web/{{ session('created')->token }}
                    </div>
                </div>
            @endif
            <div class="h5 mt-4 mb-3">Webhook Docs</div>
            <div class="accordion" id="webhookDocs">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <a class="text-dark h5" type="button" checked data-toggle="collapse" data-target="#simpleDocs" aria-expanded="true" aria-controls="simpleDocs">
                                <i class="fa fa-globe mr-1"></i>
                                Simple Webhook
                            </a>
                        </h2>
                    </div>
                    <div id="simpleDocs" class="collapse show" aria-labelledby="headingOne" data-parent="#webhookDocs">
                        <div class="card-body pb-0">
                            <table class="table table-bordered align-middle text-dark">
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
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <a class="text-dark h5" type="button" data-toggle="collapse" data-target="#githubDocs" aria-expanded="false" aria-controls="githubDocs">
                                <i class="fab fa-github mr-1"></i>
                                GitHub
                            </a>
                        </h2>
                    </div>
                    <div id="githubDocs" class="collapse" aria-labelledby="headingTwo" data-parent="#webhookDocs">
                        <div class="card-body pb-0">
                            <ol>
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
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <a class="text-dark h5" type="button" data-toggle="collapse" data-target="#gitlabDocs" aria-expanded="false" aria-controls="gitlabDocs">
                                <i class="fab fa-gitlab mr-1"></i>
                                GitLab
                            </a>
                        </h2>
                    </div>
                    <div id="gitlabDocs" class="collapse" aria-labelledby="headingThree" data-parent="#webhookDocs">
                        <div class="card-body pb-0">
                            <ol>
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
            <x-empty icon="globe" text="No webhooks found" />
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
                            <i title="Simple Webhook | ID: {{ $webhook->id }}" class="fa fa-globe mr-1"></i>
                            @elseif ($webhook->type === 'github')
                            <i title="GitHub | ID: {{ $webhook->id }}" class="fab fa-github mr-1"></i>
                            @elseif ($webhook->type === 'gitlab')
                            <i title="GitLab | ID: {{ $webhook->id }}" class="fab fa-gitlab mr-1"></i>
                            @endif
                        </td>
                        <td class="font-weight-bold">
                            {{ Str::limit($webhook->name, '20') }}
                        </td>
                        <td class="font-monospace">
                            {{ Str::limit($webhook->token, '4', '****************') }}
                        </td>
                        <td>
                            {{ Carbon::parse($webhook->created_at)->format('M d, Y') }}
                        </td>
                        <td>
                            <button wire:click="deleteWebhook({{ $webhook->id }})" class="btn btn-sm btn-block btn-danger">
                                <i class="fa fa-trash mr-1"></i>
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
