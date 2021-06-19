<div wire:init="loadAnswers">
    @if (!$readyToLoad)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading answers...
            </div>
        </div>
    @endif
    @if ($readyToLoad and count($answers) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No answers made
            </div>
        </div>
    @endif
    @foreach ($answers as $answer)
        <div class="card mb-4">
            <div class="card-header h6 py-3">
                <a
                    href="{{ route('user.done', ['username' => $answer->question->user->username]) }}"
                    class="user-popover"
                    data-id="{{ $answer->question->user->id }}"
                >
                    <img loading=lazy class="rounded-circle avatar-30" src="{{ Helper::getCDNImage($answer->question->user->avatar, 80) }}" height="30" width="30" alt="{{ $answer->question->user->username }}'s avatar" />
                </a>
                <a class="align-middle text-dark ms-2" href="{{ route('question.question', ['slug' => $answer->question->slug]) }}">
                    {{ $answer->question->title }}
                </a>
            </div>
            @livewire('answer.single-answer', [
                'answer' => $answer
            ], key($answer->id))
        </div>
    @endforeach

    {{ $readyToLoad ? $answers->links() : '' }}
</div>
