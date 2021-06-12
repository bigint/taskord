<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Sessions</span>
            <div>This is a list of devices that have logged into your account. Revoke any sessions that you do not recognize.</div>
        </div>
        @if (count($sessions) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-identification class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    Nothing has been logged!
                </div>
            </div>
        @endif
        <ul class="list-group list-group-flush">
            @foreach ($sessions as $session)
                @php
                    $agent = new Jenssegers\Agent\Agent;
                    $agent->setUserAgent($session->user_agent);
                @endphp
                <li class="list-group-item py-3 d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            @if ($agent->isPhone())
                                <x-heroicon-o-device-mobile class="heroicon heroicon-50px text-secondary" />
                            @else
                                <x-heroicon-o-desktop-computer class="heroicon heroicon-50px text-secondary" />
                            @endif
                        </div>
                        <div>
                            <div class="fw-bold mb-1 text-dark">
                                {{ $session->ip_address }}
                            </div>
                            <div class="small text-dark">
                                @if (session()->getId() === $session->id)
                                    Your current session
                                @else
                                    Last accessed on {{ carbon($session->last_activity)->format('M d, Y') }}
                                @endif
                            </div>
                            @if ($agent->browser() and $agent->platform())
                                <div class="mt-2 small text-secondary" title="{{ $session->user_agent }}">
                                    {{ $agent->browser() }} on {{ $agent->platform() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
