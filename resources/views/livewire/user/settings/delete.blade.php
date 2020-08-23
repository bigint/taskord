<div class="col-md-8">
    @include('components.alert')
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5 text-danger">Danger Zone</span>
            <div>Export and delete your account.</div>
        </div>
        <div class="card-body">
            <div class="h5 mb-3">Export your account</div>
            <a class="btn btn-success text-white" href="{{ route('user.settings.export') }}" target="_blank">
                <i class="fa fa-question mr-1"></i>
                Export now
            </a>
            <div class="h5 text-danger mt-3 mb-3">Delete your Account</div>
            @if ($confirming === Auth::id())
            <button wire:click="deleteAccount" class="btn btn-danger">
                <i class="fa fa-question mr-1"></i>
                Are you sure?
                <span wire:loading class="spinner-border spinner-border-sm ml-2" role="status"></span>
            </button>
            @else
            <button wire:click="confirmDelete" class="btn btn-danger">
                <i class="fa fa-trash-alt mr-1"></i>
                Delete now
            </button>
            @endif
        </div>
    </div>
</div>
