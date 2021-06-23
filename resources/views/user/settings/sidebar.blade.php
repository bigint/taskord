<div class="col-sm">
    <div class="card mb-4">
        <ul class="list-group list-group-flush">
            <div class="list-group-item text-dark pt-2 pb-2 fw-bold">
                Account settings
            </div>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.profile') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.profile') }}">
                <x-heroicon-o-user class="heroicon" />
                Profile
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.account') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.account') }}">
                <x-heroicon-o-at-symbol class="heroicon" />
                Account
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.appearance') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.appearance') }}">
                <x-heroicon-o-light-bulb class="heroicon" />
                Appearance
                <x:labels.beta />
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.products') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.products') }}">
                <x-heroicon-o-cube class="heroicon" />
                Products
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.patron') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.patron') }}">
                <x-heroicon-o-heart class="heroicon" />
                Patron
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.password') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.password') }}">
                <x-heroicon-o-key class="heroicon" />
                Password
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.notifications') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.notifications') }}">
                <x-heroicon-o-bell class="heroicon" />
                Notifications
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.integrations') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.integrations') }}">
                <x-heroicon-o-cloud-upload class="heroicon" />
                Integrations
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.api') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.api') }}">
                <x-heroicon-o-code class="heroicon" />
                API
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.sessions') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.sessions') }}">
                <x-heroicon-o-identification class="heroicon" />
                Sessions
                <x:labels.beta />
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.logs') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.logs') }}">
                <x-heroicon-o-collection class="heroicon" />
                Logs
            </a>
            <a class="list-group-item text-dark pt-2 pb-2 {{ Route::is('user.settings.data') ? 'active text-white' : '' }}"
                href="{{ route('user.settings.data') }}">
                <x-heroicon-o-database class="heroicon" />
                Data
            </a>
            <a class="list-group-item text-danger pt-2 pb-2 {{ Route::is('user.settings.delete') ? 'bg-danger text-white' : '' }}"
                href="{{ route('user.settings.delete') }}">
                <x-heroicon-o-exclamation class="heroicon" />
                Danger Zone
            </a>
        </ul>
    </div>
</div>
