<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.profile') active text-white @endif"
                href="{{ route('user.settings.profile') }}"
            >
                <x-heroicon-o-user class="heroicon" />
                Profile
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.account') active text-white @endif"
                href="{{ route('user.settings.account') }}"
            >
                <x-heroicon-o-at-symbol class="heroicon" />
                Account
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.patron') active text-white @endif"
                href="{{ route('user.settings.patron') }}"
            >
                <x-heroicon-o-heart class="heroicon" />
                Patron
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.password') active text-white @endif"
                href="{{ route('user.settings.password') }}"
            >
                <x-heroicon-o-key class="heroicon" />
                Password
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.notifications') active text-white @endif"
                href="{{ route('user.settings.notifications') }}"
            >
                <x-heroicon-o-bell class="heroicon" />
                Notifications
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.integrations') active text-white @endif"
                href="{{ route('user.settings.integrations') }}"
            >
                <x-heroicon-o-cloud-upload class="heroicon" />
                Integrations
            </a>
            <a
                class="list-group-item text-dark pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.api') active text-white @endif"
                href="{{ route('user.settings.api') }}"
            >
                <x-heroicon-o-code class="heroicon" />
                API
            </a>
            <a
                class="list-group-item text-danger pt-2 pb-2 @if (Route::currentRouteName() === 'user.settings.delete') bg-danger text-white @endif"
                href="{{ route('user.settings.delete') }}"
            >
                <x-heroicon-o-exclamation class="heroicon" />
                Danger Zone
            </a>
        </ul>
    </div>
</div>
