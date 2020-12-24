<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header pt-3 pb-3">
            <span class="h5">Download your data</span>
            <div>Export your account data.</div>
        </div>
        <div class="card-body">
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
                <x-heroicon-o-download class="heroicon" />
                Export now
            </a>
        </div>
    </div>
</div>
