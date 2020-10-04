<div class="col-sm">
    @auth
    @if (Auth::user()->staffShip or Auth::id() === $product->owner->id)
    <div class="card mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-block btn-success text-white font-weight-bold" data-toggle="modal" data-target="#newUpdateModal">
                <i class="fa fa-bell mr-1"></i>
                Write a product update
            </button>
            <button type="button" class="btn btn-block btn-success text-white font-weight-bold" data-toggle="modal" data-target="#editProductModal">
                <i class="fa fa-edit mr-1"></i>
                Edit Product
            </button>
            <button type="button" class="btn btn-block btn-success text-white font-weight-bold" data-toggle="modal" data-target="#addMemberModal">
                <i class="fa fa-plus mr-1"></i>
                Add Member
            </button>
        </div>
    </div>
    @livewire('product.update.new-update', [
        'product' => $product
    ])
    @livewire('product.edit-product', [
        'product' => $product
    ])
    @endif
    @livewire('product.add-member', [
        'product' => $product
    ])
    @endauth
    @if ($product->sponsor)
    <div class="card mb-4">
        <div class="card-header">
            Sponsor
        </div>
        <div class="card-body">
            <a class="btn btn-block btn-outline-primary" href="{{ $product->sponsor }}" target="_blank">
                <img class="rounded sponsor-icon mr-1" rel="preload" src="https://external-content.duckduckgo.com/ip3/{{ parse_url($product->sponsor)['host'] }}.ico" />
                <span class="font-weight-bold">Sponsor {{ $product->name }}</span>
            </a>
        </div>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            Activity by month
        </div>
        <div class="card-body">
            <canvas id="myChart" height="40"></canvas>
        </div>
    </div>
    @if ($product->website or $product->twitter or $product->producthunt or $product->repo)
    <div class="card mb-4">
        <div class="card-header">
            Social
        </div>
        <ul class="list-group list-group-flush">
            @if ($product->website)
            <a class="list-group-item link-dark" href="{{ $product->website }}" target="_blank">
                <i class="fa fa-link mr-1"></i>
                {{ Helper::removeProtocol($product->website) }}
            </a>
            @endif
            @if ($product->producthunt)
            <a class="list-group-item link-dark" href="https://www.producthunt.com/posts/{{ $product->producthunt }}" target="_blank">
                <i class="fab fa-product-hunt mr-1"></i>
                {{ Helper::removeProtocol($product->producthunt) }}
            </a>
            @endif
            @if ($product->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $product->twitter }}" target="_blank">
                <i class="fab fa-twitter mr-1"></i>
                {{ $product->twitter }}
            </a>
            @endif
            @if ($product->repo)
            <a class="list-group-item link-dark" href="{{ $product->repo }}" target="_blank">
                <i class="fab fa-github mr-1"></i>
                {{ parse_url($product->repo)['path'] }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            Team
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item pt-2 pb-2">
                <a href="{{ route('user.done', ['username' => $product->owner->username]) }}">
                    <img class="rounded-circle avatar-30" src="{{ $product->owner->avatar }}" />
                </a>
                <a href="{{ route('user.done', ['username' => $product->owner->username]) }}" class="ml-2 align-middle font-weight-bold text-dark">
                    @if ($product->owner->firstname or $product->owner->lastname)
                        {{ $product->owner->firstname }}{{ ' '.$product->owner->lastname }}
                    @else
                        {{ $product->owner->username }}
                    @endif
                </a>
            </li>
            @foreach ($product->members()->get() as $user)
            @livewire('product.team', [
                'product' => $product,
                'user' => $user
            ])
            @endforeach
        </ul>
    </div>
    @if ($product->members->contains(Auth::id()))
    @livewire('product.leave', [
        'product' => $product,
    ])
    @endif
    <x-footer />
    <script type="text/javascript">
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    data: {{ '['.implode(",", $graph).']' }},
                    backgroundColor: '#e3f9ec',
                }],
            },
            options: {
                responsive: false,
                legend: {
                    display: false
                },
                elements: {
                    line: {
                        borderColor: '#38c172',
                        borderWidth: 2
                    },
                    point: {
                        radius: 0
                    }
                },
                tooltips: {
                    enabled: false
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        display: false
                    }]
                }
            }
        });
    </script>
</div>
