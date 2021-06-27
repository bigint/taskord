<div>
    @if ($reply)
        <div class="mt-2 text-secondary">
            replied to your
            <a class="fw-bold" href="">
                answer
            </a>
        </div>
        <div class="card mt-3">
            <div class="card-body body-font">
                {!! markdown($reply->reply) !!}
            </div>
        </div>
    @else
        <div class="body-font fst-italic text-secondary mt-2">Notification source was deleted</div>
    @endif
</div>
