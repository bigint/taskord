<div class="col-sm">
    <div class="card mb-4">
        <div class="card-header">
            Admin Panel
        </div>
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'admin.stats') active text-white @endif"
                href="{{ route('admin.stats') }}"
            >
                <i class="fa fa-user mr-1"></i>
                Stats
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'admin.users') active text-white @endif"
                href="{{ route('admin.users') }}"
            >
                <i class="fa fa-at mr-1"></i>
                Users
            </a>
        </ul>
    </div>
</div>
