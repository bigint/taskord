<div wire:init="loadRecentQuestions">
    <div class="pb-2 h5 d-flex align-items-center">
        <x-heroicon-o-chat-alt-2 class="heroicon heroicon-20px me-2 text-secondary" />
        <span>Recent questions</span>
    </div>
    <div class="card mb-4">
        @if (!$readyToLoad)
            <div class="card-body">
                <x:loaders.home.question-skeleton count="5" />
            </div>
        @else
            <div class="card-body">
                @foreach ($recent_questions as $question)
                    <div
                        class="{{ $loop->index === count($recent_questions) - 1 ? '' : 'mb-2' }} {{ $question->patron_only ? 'bg-patron-question recent-questions' : '' }} d-flex align-items-center">
                        <a href="{{ route('user.done', ['username' => $question->user->username]) }}"
                            class="user-popover" data-id="{{ $question->user->id }}">
                            <img loading=lazy class="rounded-circle avatar-30"
                                src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" height="30" width="30"
                                alt="{{ $question->user->username }}'s avatar" />
                        </a>
                        <div class="ms-3">
                            <a href="{{ route('question.question', ['slug' => $question->slug]) }}"
                                class="align-middle text-dark fw-bold">{{ Str::words($question->title, '10') }}</a>
                            @if ($question->created_at->isToday())
                                <span class="badge bg-hero ms-2 align-middle">New</span>
                            @endif
                            <div>
                                <a href="{{ route('user.done', ['username' => $question->user->username]) }}"
                                    data-id="{{ $question->user->id }}" class="user-popover text-secondary">
                                    by {{ '@' . $question->user->username }}
                                </a>
                                @if ($question->answers_count >= 1)
                                    <span class="ms-1 text-secondary">
                                        · {{ $question->answers_count }}
                                        {{ pluralize('answer', $question->answers_count) }}
                                    </span>
                                @endif
                                <span class="avatar-stack ms-1">
                                    @foreach ($question->answers->groupBy('user_id')->take(5) as $answer)
                                        <img loading=lazy
                                            class="user-popover replies-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}"
                                            data-id="{{ $answer[0]->user->id }}"
                                            src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}" height="18"
                                            width="18" alt="{{ $answer[0]->user->username }}'s avatar" />
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
