<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.profile') active text-white @endif"
                href="{{ route('user.settings.profile') }}"
            >
                <i class="fa fa-user me-1"></i>
                Profile
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.account') active text-white @endif"
                href="{{ route('user.settings.account') }}"
            >
                <i class="fa fa-at me-1"></i>
                Account
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.patron') active text-white @endif"
                href="{{ route('user.settings.patron') }}"
            >
                <i class="fa fa-heart me-1"></i>
                Patron
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.password') active text-white @endif"
                href="{{ route('user.settings.password') }}"
            >
                <i class="fa fa-key me-1"></i>
                Password
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.notifications') active text-white @endif"
                href="{{ route('user.settings.notifications') }}"
            >
                <i class="fa fa-bell me-1"></i>
                Notifications
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.integrations') active text-white @endif"
                href="{{ route('user.settings.integrations') }}"
            >
                <i class="fa fa-anchor me-1"></i>
                Integrations
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.api') active text-white @endif"
                href="{{ route('user.settings.api') }}"
            >
                <i class="fa fa-code me-1"></i>
                API
            </a>
            <a
                class="list-group-item text-danger pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.delete') bg-danger text-white @endif"
                href="{{ route('user.settings.delete') }}"
            >
                <i class="fa fa-exclamation-triangle me-1"></i>
                Danger Zone
            </a>
        </ul>
    </div>
</div>
