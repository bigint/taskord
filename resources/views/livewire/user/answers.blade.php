<div>
    @if (count($answers) === 0)
    <x-empty icon="comments" text="No answers made" />
    @endif
    @foreach ($answers as $answer)
        <div class="card mb-4">
            <div class="card-header h6 pt-3 pb-3">
                <a
                    href="{{ route('user.done', ['username' => $answer->question->user->username]) }}"
                    class="user-hover"
                    data-id="{{ $answer->question->user->id }}"
                >
                    <img class="rounded-circle avatar-30" src="{{ $answer->question->user->avatar }}" alt="{{ $answer->question->user->username }}'s avatar" />
                </a>
                <a class="align-middle text-dark ms-2" href="{{ route('question.question', ['id' => $answer->question->id]) }}">
                    {{ $answer->question->title }}
                </a>
            </div>
            @livewire('answer.single-answer', [
                'answer' => $answer
            ], key($answer->id))
        </div>
    @endforeach

    {{ $answers->links() }}
</div>
