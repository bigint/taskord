<div>
    @foreach ($deployments as $deployment)
    <div>
        <code>
            {{ $deployment->id }}
        </code>
        @if ($deployment->status === 'success')
        <span class="badge bg-success">
            Deployment Successful
        </span>
        @elseif ($deployment->status === 'failed')
        <span class="badge bg-danger">
            Deployment Failed
        </span>
        @elseif ($deployment->status === 'pending')
        <span class="badge bg-info">
            Deployment Pending
        </span>
        @elseif ($deployment->status === 'running')
        <span class="badge bg-info">
            In Progress
        </span>
        @elseif ($deployment->status === 'preparing')
        <span class="badge bg-info">
            Preparing to deploy
        </span>
        @elseif ($deployment->status === 'canceled')
        <span class="badge bg-info">
            Deployment Canceled
        </span>
        @endif
        <span class="ms-1">
            {{ carbon($deployment->created_at)->diffForHumans() }}
        </span>
        <a href="{{ $deployment->web_url }}" class="fw-bold ms-1" target="_blank">
            <x-heroicon-o-external-link class="heroicon" />
        </a>
    </div>
    @endforeach
</div>
