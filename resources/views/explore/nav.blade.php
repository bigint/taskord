<ul class="nav nav-pills justify-content-center align-items-center explore-nav bg-white border-bottom py-3">
    <li class="nav-item px-1">
        <a class="nav-link {{ Route::is('explore.explore') ? 'active' : '' }}"
            href="{{ route('explore.explore') }}">Popular Tasks</a>
    </li>
    @if (feature('explore_makers'))
        <li class="nav-item px-1">
            <a class="nav-link {{ Route::is('explore.makers') ? 'active' : '' }}"
                href="{{ route('explore.makers') }}">Featured Makers
                <x:labels.beta />
            </a>
        </li>
    @endif
    @if (feature('explore_products'))
        <li class="nav-item px-1">
            <a class="nav-link" href="#">Products
                <x:labels.staff-ship />
            </a>
        </li>
    @endif
</ul>
