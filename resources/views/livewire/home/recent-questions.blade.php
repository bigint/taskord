<div wire:init="loadRecentQuestions">
    <div class="pb-2 h5">
        <x-heroicon-o-chat-alt-2 class="heroicon-2x ms-1 text-secondary" />
        Recent questions
    </div>
    <div class="card mb-4">
        <div class="card-body">
            @if (!$readyToLoad)
            <div class="card-body text-center">
                <div class="spinner-border spinner-border-sm taskord-spinner text-secondary" role="status"></div>
            </div>
            @endif
            @foreach ($recent_questions as $question)
                <div class="{{ $loop->index === count($recent_questions) - 1 ? '' : 'mb-2' }} {{ $question->patronOnly ? 'bg-patron recent-questions' : '' }} d-flex align-items-center">
                    <a
                        href="{{ route('user.done', ['username' => $question->user->username]) }}"
                        class="user-popover"
                        data-id="{{ $question->user->id }}"
                    >
                        <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" height="30" width="30" alt="{{ $question->user->username }}'s avatar" />
                    </a>
                    <div class="ms-3">
                        <a href="{{ route('question.question', ['id' => $question->id]) }}" class="align-middle text-dark fw-bold">{{ Str::words($question->title, '10') }}</a>
                        @if ($question->created_at->isToday())
                        <span class="badge bg-success ms-2 align-middle">New</span>
                        @endif
                        <div>
                            <a
                                href="{{ route('user.done', ['username' => $question->user->username]) }}"
                                data-id="{{ $question->user->id }}"
                                class="user-popover text-secondary"
                            >
                                by {{ '@'.$question->user->username }}
                            </a>
                            @if ($question->answer->count('id') >= 1)
                            <span class="ms-1 text-secondary">
                                · {{ $question->answer->count('id') }} {{ $question->answer->count('id') >= 1 ? 'answers' : 'answer' }}
                            </span>
                            @endif
                            <span class="avatar-stack ms-1">
                                @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
                                <img
                                    loading=lazy
                                    class="user-popover replies-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}"
                                    data-id="{{ $answer[0]->user->id }}"
                                    src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}"
                                    height="18" width="18"
                                    alt="{{ $answer[0]->user->username }}'s avatar"
                                />
                                @endforeach
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
