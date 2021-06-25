<div class="col-sm d-inline-bock">
    <div class="d-block">
        @auth
            @can('staff.ops')
                <livewire:user.moderator :user="$user" />
            @endcan
            @if (auth()->user()->id === $user->id)
                @section('scripts')
                    <script src="{{ mix('js/emoji-picker.js') }}"></script>
                @stop
                <div class="text-uppercase fw-bold text-secondary pb-2">
                    Status
                    <x:labels.beta />
                </div>
                @livewire('user.status', [
                'user' => $user
                ])
            @endif
        @endauth
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <div class="text-uppercase fw-bold text-secondary pb-2">
            Activity Graph
        </div>
        <div class="card mb-4">
            <livewire:user.graph :user="$user" />
        </div>
        @if ($user->sponsor)
            <div class="text-uppercase fw-bold text-secondary pb-2">
                <x-heroicon-o-heart class="heroicon text-danger" />
                Sponsor
            </div>
            <div class="mb-4">
                <a class="btn w-100 btn-outline-primary rounded-pill" href="{{ $user->sponsor }}" target="_blank"
                    rel="noreferrer">
                    <img loading=lazy class="rounded sponsor-icon me-1" rel="preload"
                        src="https://favicon.splitbee.io/?url={{ parse_url($user->sponsor)['host'] }}" />
                    <span class="fw-bold">Sponsor {{ '@' . $user->username }}</span>
                </a>
            </div>
        @endif
        @if ($user->website or $user->twitter or $user->twitch or $user->telegram or $user->github or $user->youtube)
            <div class="text-uppercase fw-bold text-secondary pb-2">
                Social
            </div>
            <div class="card mb-4">
                <ul class="list-group list-group-flush">
                    @if ($user->website)
                        <a class="list-group-item link-dark" href="{{ $user->website }}" target="_blank"
                            rel="noreferrer">
                            <img loading=lazy class="rounded favicon me-1" rel="preload"
                                src="https://favicon.splitbee.io/?url={{ parse_url($user->website)['host'] }}" />
                            {{ Helper::removeProtocol($user->website) }}
                        </a>
                    @endif
                    @if ($user->twitter)
                        <a class="list-group-item link-dark" href="https://twitter.com/{{ $user->twitter }}"
                            target="_blank" rel="noreferrer">
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/twitter_4cXueyhRfH.svg"
                                loading=lazy />
                            {{ $user->twitter }}
                        </a>
                    @endif
                    @if ($user->twitch)
                        <a class="list-group-item link-dark" href="https://twitch.tv/{{ $user->twitch }}"
                            target="_blank" rel="noreferrer">
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/twitch_ZzpKWQt7T.svg"
                                loading=lazy />
                            {{ $user->twitch }}
                        </a>
                    @endif
                    @if ($user->telegram)
                        <a class="list-group-item link-dark" href="https://t.me/{{ $user->telegram }}"
                            target="_blank" rel="noreferrer">
                            <img class="brand-icon"
                                src="https://ik.imagekit.io/taskordimg/icons/telegram_4ea__J3dwB.svg" loading=lazy />
                            {{ $user->telegram }}
                        </a>
                    @endif
                    @if ($user->github)
                        <a class="list-group-item link-dark" href="https://github.com/{{ $user->github }}"
                            target="_blank" rel="noreferrer">
                            <img class="brand-icon github-logo"
                                src="https://ik.imagekit.io/taskordimg/icons/github_9E8bhMFJtH.svg" loading=lazy />
                            {{ $user->github }}
                        </a>
                    @endif
                    @if ($user->youtube)
                        <a class="list-group-item link-dark" href="https://youtube.com/{{ $user->youtube }}"
                            target="_blank" rel="noreferrer">
                            <img class="brand-icon" src="https://ik.imagekit.io/taskordimg/icons/youtube_qUsz_87ogn.svg"
                                loading=lazy />
                            {{ $user->youtube }}
                        </a>
                    @endif
                </ul>
            </div>
        @endif
        <div class="text-uppercase fw-bold text-secondary pb-2">
            Products
        </div>
        <div class="card mb-4">
            <livewire:user.sidebar-products :user="$user" />
        </div>
        <x-footer />
    </div>
</div>
