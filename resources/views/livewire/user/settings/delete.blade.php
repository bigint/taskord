<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5 text-danger">Danger Zone</span>
            <div>Export and delete your account.</div>
        </div>
        <div class="card-body">
            <x-alert />
            <div class="h5 mb-3">Download your data</div>
            <div class="mb-3">
                Most of the personal data that Taskord has about you is accessible through the Taskord app (e.g. tasks, comments, questions, answers, patron details, and user account). If you would like to get a consolidated copy of this data, you can download it by clicking the "Export Now" button.
            </div>
            <div class="mb-3">
                As the downloadable file you will receive will contain your profile information, you should keep it secure and be careful when storing, sending, or uploading it to any other services.
            </div>
            <div class="mb-3">
                If you have any questions or concerns about the personal data contained in your downloadable file, please <a href="https://taskord.freshdesk.com/support/tickets/new" target="_blank" rel="noreferrer">contact us</a>.
            </div>
            <a class="btn btn-success text-white" href="{{ route('user.settings.export') }}" target="_blank" rel="noreferrer">
                <i class="fa fa-download me-1"></i>
                Export now
            </a>
            <div class="h5 text-danger mt-3 mb-3">Delete your Account</div>
            <div class="mb-3">
                Deleting your account is permanent. All your data will be wiped out immediately and you won't be able to get it back.
            </div>
            @if ($confirming === Auth::id())
            <button wire:click="deleteAccount" class="btn btn-danger">
                <x-heroicon-o-question-mark-circle class="heroicon" />
                Are you sure?
                <span wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
            </button>
            @else
            <button wire:click="confirmDelete" class="btn btn-danger">
                <i class="fa fa-trash-alt me-1"></i>
                Delete now
            </button>
            @endif
        </div>
    </div>
</div>
