@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <x-heroicon-o-check class="heroicon" />
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <x-heroicon-o-x class="heroicon" />
        {{ session('error') }}
    </div>
@endif
@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <x-heroicon-o-exclamation class="heroicon" />
        {{ session('warning') }}
    </div>
@endif
