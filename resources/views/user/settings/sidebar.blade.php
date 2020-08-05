<div class="col-sm">
    <div class="card mb-4">
        <div class="card-header">
            Settings
        </div>
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.profile') active text-white @endif"
                href="{{ route('user.settings.profile') }}"
            >
                <i class="fa fa-user mr-1"></i>
                Profile
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.account') active text-white @endif"
                href="{{ route('user.settings.account') }}"
            >
                <i class="fa fa-at mr-1"></i>
                Account
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.password') active text-white @endif"
                href="{{ route('user.settings.password') }}"
            >
                <i class="fa fa-key mr-1"></i>
                Password
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.notifications') active text-white @endif"
                href="{{ route('user.settings.notifications') }}"
            >
                <i class="fa fa-bell mr-1"></i>
                Notifications
                @if (Route::currentRouteName() === 'user.settings.notifications')
                @include('components.beta', ['background' => 'white'])
                @else
                @include('components.beta', ['background' => 'dark'])
                @endif
            </a>
            <a
                class="list-group-item text-danger pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.delete') bg-danger text-white @endif"
                href="{{ route('user.settings.delete') }}"
            >
                <i class="fa fa-exclamation-triangle mr-1"></i>
                Danger Zone
            </a>
        </ul>
    </div>
</div>
