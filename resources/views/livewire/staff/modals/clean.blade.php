<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="cleanModal" tabindex="-1"
    aria-labelledby="cleanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="cleanModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="fw-bold mb-2 text-danger">This will do following actions</div>
                <ul class="mb-0 text-dark">
                    <li>Clean <b>Application Cache</b></li>
                    <li>Clean Cached <b>Application Views</b></li>
                    <li>Clean Cached <b>Configuration</b></li>
                    <li>Purge <b>Cloudflare Cache</b></li>
                    <li>Cache the <b>Configuration</b></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill"
                    data-bs-dismiss="modal">Close</button>
                <button class="btn btn-outline-primary rounded-pill" wire:loading.attr="disabled" wire:click="clean"
                    data-bs-dismiss="modal">
                    Clean Cache
                </button>
            </div>
        </div>
    </div>
</div>
