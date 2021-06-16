<div>
    <div>
        <span class="fw-bold">Status: </span>
        @if (count($commits) === 0)
            <span class="badge bg-success">
                Taskord is up-to-date
            </span>
        @else
            <span class="badge bg-danger">
                Updates available
            </span>
        @endif
        @if (count($commits) !== 0)
            <ul class="bg-patron-question mt-3 py-2 rounded border border-warning">
                @foreach ($commits as $commit)
                    <li>
                        <span>{{ $commit->title }}</span>
                        <a href="{{ $commit->web_url }}" class="fw-bold ms-1" target="_blank">
                            <x-heroicon-o-external-link class="heroicon heroicon-15px" />
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
