@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-dismiss="alert"></button>
        <i class="fa fa-check mr-1"></i>
        {{ session('success') }}
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-dismiss="alert"></button>
        <i class="fa fa-times mr-1"></i>
        {{ session('error') }}
    </div>
@endif
@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-2">
        <button type="button" class="btn-close small" data-dismiss="alert"></button>
        <i class="fa fa-exclamation-triangle mr-1"></i>
        {{ session('warning') }}
    </div>
@endif
