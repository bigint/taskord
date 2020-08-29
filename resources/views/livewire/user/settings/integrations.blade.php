<div class="col-md-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Integrations</span>
            <div>Just send a POST event from anywhere</div>
        </div>
        <div class="card-body">
            @include('components.alert')
            <span class="h5">Create Webhook</span>
            <form wire:submit.prevent="submit">
                <div class="mb-3 mt-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Webhook Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
            <div class="h5 mt-3">Parameters</div>
            <table class="table table-bordered align-middle">
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
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Active webhooks</span>
            <div>Webhooks that are active</div>
        </div>
        <div class="card-body">
            @if (count($user->webhooks) === 0)
            @include('components.empty', [
                'icon' => 'globe',
                'text' => 'No webhooks found',
            ])
            @else
            <table class="table table-bordered align-middle">
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
                            <i title="Web | ID: {{ $webhook->id }}" class="fa fa-globe mr-1"></i>
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
