<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="deployModal" tabindex="-1"
    aria-labelledby="deployModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="deployModalLabel">🚀 Is it ready to deploy?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-dark">Latest Commit Details</h4>
                <div id="deployModalCommitBody" class="text-dark">
                    <div class="mt-2 spinner-border taskord-spinner text-secondary" role="status"></div>
                </div>
                <h4 class="mt-3 text-dark">Last CI Details</h4>
                <div id="deployModalCIBody" class="text-dark">
                    <div class="mt-2 spinner-border taskord-spinner text-secondary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
