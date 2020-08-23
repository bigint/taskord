<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-check mr-1"></i>
                Tasks
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-comments mr-1"></i>
                Task Comments
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-question mr-1"></i>
                Questions
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-comment mr-1"></i>
                Answers
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-box-open mr-1"></i>
                Products
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'search.tasks') active text-white @endif"
                href="{{ route('search.tasks') }}"
            >
                <i class="fa fa-users mr-1"></i>
                Users
            </a>
        </ul>
    </div>
</div>
