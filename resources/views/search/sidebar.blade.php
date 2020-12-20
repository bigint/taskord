<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-check class="heroicon" />
                Tasks
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.comments') active text-white @endif"
                href="{{ route('search.comments', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-chat-alt-2 class="heroicon" />
                Task Comments
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.questions') active text-white @endif"
                href="{{ route('search.questions', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-question-mark-circle class="heroicon" />
                Questions
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.answers') active text-white @endif"
                href="{{ route('search.answers', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-chat-alt class="heroicon" />
                Answers
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.products') active text-white @endif"
                href="{{ route('search.products', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-cube class="heroicon" />
                <i class="fa fa-box-open me-1"></i>
                Products
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.users') active text-white @endif"
                href="{{ route('search.users', ['q' => $searchTerm]) }}"
            >
                <x-heroicon-o-users class="heroicon" />
                Users
            </a>
        </ul>
    </div>
</div>
