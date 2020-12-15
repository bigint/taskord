@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <i class="fa fa-check me-1"></i>
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <i class="fa fa-times me-1"></i>
        {{ session('error') }}
    </div>
@endif
@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-bs-dismiss="alert"></button>
        <i class="fa fa-exclamation-triangle me-1"></i>
        {{ session('warning') }}
    </div>
@endif
