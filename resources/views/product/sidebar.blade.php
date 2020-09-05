<div class="col-sm">
    @auth
    @if (Auth::user()->staffShip or Auth::id() === $product->user->id)
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
        </div>
    </div>
    @livewire('product.update.new-update', [
        'product' => $product
    ])
    @livewire('product.edit-product', [
        'product' => $product
    ])
    @endif
    @endauth
    <div class="card mb-4">
        <div class="card-header">
            Activity by month
        </div>
        <div class="card-body">
            <canvas id="myChart" height="40"></canvas>
        </div>
    </div>
    @if ($product->website or $product->twitter or $product->producthunt or $product->github)
    <div class="card mb-4">
        <div class="card-header">
            Social
        </div>
        <ul class="list-group list-group-flush">
            @if ($product->website)
            <a class="list-group-item link-dark" href="{{ $product->website }}">
                <i class="fa fa-link mr-1"></i>
                {{ Helper::removeProtocol($product->website) }}
            </a>
            @endif
            @if ($product->producthunt)
            <a class="list-group-item link-dark" href="https://www.producthunt.com/posts/{{ $product->producthunt }}">
                <i class="fa fa-product-hunt mr-1"></i>
                {{ Helper::removeProtocol($product->producthunt) }}
            </a>
            @endif
            @if ($product->twitter)
            <a class="list-group-item link-dark" href="https://twitter.com/{{ $product->twitter }}">
                <i class="fa fa-twitter mr-1"></i>
                {{ $product->twitter }}
            </a>
            @endif
            @if ($product->github)
            <a class="list-group-item link-dark" href="https://github.com/{{ $product->github }}">
                <i class="fa fa-github mr-1"></i>
                {{ $product->github }}
            </a>
            @endif
        </ul>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            Creator
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item pt-2 pb-2">
                <a href="{{ route('user.done', ['username' => $product->user->username]) }}">
                    <img class="rounded-circle avatar-30" src="{{ asset('storage/' . $product->user->avatar) }}" />
                </a>
                <a href="{{ route('user.done', ['username' => $product->user->username]) }}" class="ml-2 align-middle font-weight-bold text-dark">
                    @if ($product->user->firstname or $product->user->lastname)
                        {{ $product->user->firstname }}{{ ' '.$product->user->lastname }}
                    @else
                        {{ $product->user->username }}
                    @endif
                </a>
            </li>
        </ul>
    </div>
    @include('components.footer')
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
