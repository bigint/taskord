<div class="card mb-4">
    <div class="card-header">
        <i class="fa fa-fire text-danger mr-1"></i>
        Trending
    </div>
    <ul class="list-group list-group-flush">
        @foreach ($trending as $question)
        <li class="d-flex list-group-item align-items-center justify-content-between">
            <div>
                <a href="{{ route('question.question', ['id' => $question->id]) }}" class="align-text-top text-dark">
                    <span class="font-weight-bold">
                        {{ Str::words($question->title, '10') }}
                    </span>
                </a>
                <div class="text-secondary small mt-1">
                    <i class="fa fa-eye mr-1"></i>
                    <span class="font-weight-bold">{{ views($question)->remember()->unique()->count('id') }}</span>
                    {{ views($question)->remember()->unique()->count('id') <= 1 ? 'View' : 'Views' }}
                </div>
            </div>
            <a
                href="{{ route('user.done', ['username' => $question->user->username]) }}"
                id="user-hover"
                data-id="{{ $question->user->id }}"
            >
                <img class="rounded-circle avatar-30 ml-3 float-right" src="{{ $question->user->avatar }}" />
            </a>
        </li>
        @endforeach
    </ul>
</div>
