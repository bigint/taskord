<div class="text-uppercase fw-bold text-secondary pb-2">
    <x-heroicon-o-fire class="heroicon text-danger" />
    Trending
</div>
<div class="card mb-4">
    <div class="pt-2 pb-2">
        @foreach ($trending as $question)
        <div class="d-flex align-items-center justify-content-between py-2 px-3">
            <div>
                <a href="{{ route('question.question', ['id' => $question->id]) }}" class="align-text-top text-dark">
                    <span class="fw-bold">
                        {{ Str::words($question->title, '10') }}
                    </span>
                </a>
                <div class="text-secondary small mt-1">
                    <x-heroicon-o-eye class="heroicon" />
                    <span class="fw-bold">{{ views($question)->remember()->unique()->count('id') }}</span>
                    {{ views($question)->remember()->unique()->count('id') <= 1 ? 'View' : 'Views' }}
                </div>
            </div>
            <a
                href="{{ route('user.done', ['username' => $question->user->username]) }}"
                class="user-hover"
                data-id="{{ $question->user->id }}"
            >
                <img loading=lazy class="rounded-circle avatar-30 ms-3 float-end" src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" alt="{{ $question->user->username }}'s avatar" />
            </a>
        </div>
        @endforeach
    </div>
</div>
