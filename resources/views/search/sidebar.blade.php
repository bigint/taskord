<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-check me-1"></i>
                Tasks
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.comments') active text-white @endif"
                href="{{ route('search.comments', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-comments me-1"></i>
                Task Comments
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.questions') active text-white @endif"
                href="{{ route('search.questions', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-question me-1"></i>
                Questions
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.answers') active text-white @endif"
                href="{{ route('search.answers', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-comment me-1"></i>
                Answers
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.products') active text-white @endif"
                href="{{ route('search.products', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-box-open me-1"></i>
                Products
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.users') active text-white @endif"
                href="{{ route('search.users', ['q' => $searchTerm]) }}"
            >
                <i class="fa fa-users me-1"></i>
                Users
            </a>
        </ul>
    </div>
</div>
