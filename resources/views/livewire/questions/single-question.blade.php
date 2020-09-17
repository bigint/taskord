<div class="card mb-2 {{ $question->patronOnly ? 'bg-patron' : '' }}">
    <div class="card-body">
        <x-alert />
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $question->user->username]) }}">
                <img class="avatar-40 rounded-circle" src="{{ $question->user->avatar }}" />
            </a>
            <span class="ml-2">
                <a href="{{ route('user.done', ['username' => $question->user->username]) }}" class="font-weight-bold text-dark">
                    @if ($question->user->firstname or $question->user->lastname)
                        {{ $question->user->firstname }}{{ ' '.$question->user->lastname }}
                    @else
                        {{ $question->user->username }}
                    @endif
                    @if ($question->user->isVerified)
                    <i class="fa fa-check-circle ml-1 text-primary" title="Verified"></i>
                    @endif
                    @if ($question->user->isPatron)
                        <a class="ml-1 small" href="{{ route('patron.home') }}" title="Patron">
                            {{ Emoji::handshake() }}
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $question->user->username }}</div>
            </span>
            <span class="align-text-top small float-right ml-auto">
                <a class="text-black-50" href="{{ route('question.question', ['id' => $question->id]) }}">
                    {{ Carbon::parse($question->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        <a href="{{ route('question.question', ['id' => $question->id]) }}" class="h5 align-text-top font-weight-bold text-dark">
            @if ($type !== "question.question")
                {{ Str::words($question->title, '10') }}
            @else
                {{ $question->title }}
            @endif
        </a>
        <div class="mt-2 body-font">
            @if ($type !== "question.question")
                @if (!$question->patronOnly)
                    @markdown(Str::words($question->body, '30'))
                @endif
            @else
                @markdown($question->body)
            @endif
        </div>
        <div class="mt-3">
            @auth
            @if (Auth::user()->hasLiked($question))
                <button role="button" class="btn btn-task btn-success text-white mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    <span class="small text-white font-weight-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($question->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                </button>
            @else
                <button role="button" class="btn btn-task btn-outline-success mr-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    {{ Emoji::clappingHands() }}
                    @if ($question->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($question->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </button>
            @endif
            @if (Auth::user()->staffShip or Auth::id() === $question->user->id)
            @if ($type === "question.question")
            <button role="button" class="btn btn-task btn-outline-info text-white mr-1" data-toggle="modal" data-target="#editQuestionModal">
                {{ Emoji::writingHand() }}
                <span class="small text-dark font-weight-bold">
                    Edit
                </span>
            </button>
            @livewire('question.edit-question', [
                'question' => $question
            ])
            @endif
            @if ($confirming === $question->id)
            <button role="button" class="btn btn-task btn-danger mr-1" wire:click="deleteQuestion" wire:loading.attr="disabled" wire:offline.attr="disabled">
                Are you sure?
                <span wire:target="deleteQuestion" wire:loading class="spinner-border spinner-border-mini ml-2" role="status"></span>
            </button>
            @else
            <button role="button" class="btn btn-task btn-outline-danger mr-1" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                {{ Emoji::wastebasket() }}
            </button>
            @endif
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success mr-1">
                    {{ Emoji::clappingHands() }}
                    @if ($question->likerscount() !== 0)
                    <span class="small text-dark font-weight-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ml-1">
                    @foreach($question->likers->take(5) as $user)
                    <img class="praise-avatar rounded-circle {{ $loop->last ? 'mr-0' : '' }}" src="{{ $user->avatar }}" />
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
            @if (views($question)->remember()->count('id') > 0)
            <span class="align-middle ml-2 mr-2">
                <i class="fa fa-eye mr-1"></i>
                <span class="text-secondary">
                    <span class="font-weight-bold">{{ number_format(views($question)->remember()->unique()->count('id')) }}</span>
                    {{ views($question)->remember()->unique()->count('id') <= 1 ? 'View' : 'Views' }}
                </span>
            </span>
            @endif
            @if ($type !== "question.question")
            <a href="{{ route('question.question', ['id' => $question->id]) }}" class="avatar-stack text-dark">
                @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
                <img class="rounded-circle avatar avatar-30" src="{{ $answer[0]->user->avatar }}" />
                @endforeach
                @if ($question->answer->groupBy('user_id')->count('id') >= 5)
                <span class="ml-3 pl-1 align-middle font-weight-bold small">
                    +{{ number_format($question->answer->groupBy('user_id')->count('id') - 5) }} more
                </span>
                @endif
            </a>
            @endif
        </div>
    </div>
</div>
