<div wire:init="loadCommitData" class="text-dark">
    <h4 class="mt-3">Latest Commit Details</h4>
    @if ($readyToLoad)
    <div>
        <span class="fw-bold">Remote: </span>
        <code class="fw-bold">
            {{ $commit->id }}
        </code>
    </div>
    <div>
        <span class="fw-bold">Deployed: </span>
        <code class="fw-bold">
            {{ git('rev-parse HEAD') ?: 'Something went wrong!' }}
        </code>
    </div>
    <div>
        <span class="fw-bold">Message: </span>
        {{ $commit->title }}
    </div>
    <div>
        <span class="fw-bold">Date: </span>
        {{ $commit->committed_date }}
    </div>
    <div>
        <span class="fw-bold">Author: </span>
        {{ $commit->committer_name }} - {{ $commit->committer_email }}
    </div>
    @else
    <div>Loading...</div>
    @endif
</div>
