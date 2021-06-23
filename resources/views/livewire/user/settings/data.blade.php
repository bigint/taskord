<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3">
            <span class="h5">Download your data</span>
            <div>Export your account data.</div>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h5 class="mb-3">Export your account</h5>
                <div class="mb-3">
                    Most of the personal data that Taskord has about you is accessible through the Taskord app (e.g.
                    tasks, comments, questions, answers, patron details, and user account). If you would like to get a
                    consolidated copy of this data, you can download it by clicking the "Export Now" button.
                </div>
                <div class="mb-3">
                    As the downloadable file you will receive will contain your profile information, you should keep it
                    secure and be careful when storing, sending, or uploading it to any other services.
                </div>
                <div class="mb-3">
                    If you have any questions or concerns about the personal data contained in your downloadable file,
                    please <a href="https://taskord.com/contact" target="_blank">contact us</a>.
                </div>
                <a class="btn btn-outline-success rounded-pill" href="{{ route('user.settings.export.account') }}"
                    target="_blank">
                    <x-heroicon-o-download class="heroicon" />
                    Export account now
                </a>
            </div>
            <hr />
            <div class="mt-4">
                <h5 class="mb-3">Export your logs</h5>
                <div class="mb-3">
                    You can download and review the security log for your user account to better understand actions
                    you've performed and actions others have performed that involve you.
                </div>
                <a class="btn btn-outline-success rounded-pill" href="{{ route('user.settings.export.logs') }}"
                    target="_blank">
                    <x-heroicon-o-download class="heroicon" />
                    Export logs now
                </a>
            </div>
        </div>
    </div>
</div>
