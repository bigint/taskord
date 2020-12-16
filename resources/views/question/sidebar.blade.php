<div class="text-uppercase fw-bold text-black-50 pb-2">
    <i class="fa fa-fire text-danger me-1"></i>
    Trending
</div>
<div class="card mb-4">
    <div class="pt-2 pb-2">
        @foreach ($trending as $question)
        <div class="d-flex align-items-center justify-content-between py-2 px-3">
            <a
                href="{{ route('user.done', ['username' => $question->user->username]) }}"
                id="user-hover"
                data-id="{{ $question->user->id }}"
            >
                <img class="rounded-circle avatar-30 ms-3 float-end" src="{{ $question->user->avatar }}" />
            </a>
        </div>
        @endforeach
    </div>
</div>
