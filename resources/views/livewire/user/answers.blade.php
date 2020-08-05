<div>
    @if (count($answers) === 0)
    <div class="card-body text-center">
        <i class="fa fa-3x fa-comments mb-3 text-primary"></i>
        <div class="h5">
            No answers made!
        </div>
    </div>
    @endif
    @foreach ($answers as $answer)
        <div class="card mb-4">
            <div class="card-header h6 pt-3 pb-3">
                <a href="{{ route('user.done', ['username' => $answer->question->user->username]) }}">
                    <img class="rounded-circle avatar-30" src="{{ $answer->question->user->avatar }}" />
                </a>
                <a class="align-middle text-dark ml-2">
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
