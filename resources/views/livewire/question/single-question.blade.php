<div class="card mb-2 {{ $question->patronOnly ? 'bg-patron' : '' }}">
    <div class="card-body">
        <x-alert />
        <div class="d-flex align-items-center">
            <a href="{{ route('user.done', ['username' => $question->user->username]) }}">
<<<<<<< HEAD
                <img loading=lazy class="avatar-40 rounded-circle" src="{{ Helper::getCDNImage($question->user->avatar, 50) }}" alt="{{ $question->user->username }}'s avatar" />
=======
                <img loading=lazy class="avatar-40 rounded-circle" src="{{ Helper::getCDNImage($question->user->avatar, 80) }}" alt="{{ $question->user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
            </a>
            <span class="ms-2">
                <a
                    href="{{ route('user.done', ['username' => $question->user->username]) }}"
                    class="fw-bold text-dark user-hover"
                    data-id="{{ $question->user->id }}"
                >
                    @if ($question->user->firstname or $question->user->lastname)
                        {{ $question->user->firstname }}{{ ' '.$question->user->lastname }}
                    @else
                        {{ $question->user->username }}
                    @endif
                    @if ($question->user->isVerified)
                    <x-heroicon-s-badge-check class="heroicon ms-1 text-primary verified" />
                    @endif
                    @if ($question->user->isPatron)
                        <a class="patron ms-1 small" href="{{ route('patron.home') }}">
                            🤝
                        </a>
                    @endif
                </a>
                <div class="small">{{ "@" . $question->user->username }}</div>
            </span>
            <span class="align-text-top small float-end ms-auto">
                <a class="text-secondary" href="{{ route('question.question', ['id' => $question->id]) }}">
                    {{ Carbon::parse($question->created_at)->diffForHumans() }}
                </a>
            </span>
        </div>
    </div>
    <div class="card-body pt-1">
        @if ($question->hidden)
        <span class="task-font fst-italic text-secondary">Question was hidden by moderator</span>
        @else
        <a href="{{ route('question.question', ['id' => $question->id]) }}" class="h5 align-text-top fw-bold text-dark">
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
        @endif
        <div class="mt-3">
            @auth
            @if (Auth::user()->hasLiked($question))
                <button role="button" class="btn btn-task btn-success text-white me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    👏
                    <span class="small text-white fw-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($question->likers->take(5) as $user)
<<<<<<< HEAD
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 50) }}" alt="{{ $user->username }}'s avatar" />
=======
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                    @endforeach
                    </span>
                </button>
            @else
                <button role="button" class="btn btn-task btn-outline-success me-1" wire:click="togglePraise" wire:loading.attr="disabled" wire:offline.attr="disabled">
                    👏
                    @if ($question->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($question->likers->take(5) as $user)
<<<<<<< HEAD
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 50) }}" alt="{{ $user->username }}'s avatar" />
=======
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                    @endforeach
                    </span>
                    @endif
                </button>
            @endif
            @if (Auth::user()->staffShip or Auth::id() === $question->user->id)
            @if ($type === "question.question")
            <button role="button" class="btn btn-task btn-outline-info text-white me-1" data-bs-toggle="modal" data-bs-target="#editQuestionModal">
                ✍
                <span class="small text-dark fw-bold">
                    Edit
                </span>
            </button>
            @livewire('question.edit-question', [
                'question' => $question
            ])
            @endif
            @if ($confirming === $question->id)
            <button role="button" class="btn btn-task btn-danger me-1" wire:click="deleteQuestion" wire:loading.attr="disabled" wire:offline.attr="disabled">
                Are you sure?
                <span wire:target="deleteQuestion" wire:loading class="spinner-border spinner-border-mini ms-2" role="status"></span>
            </button>
            @else
            <button role="button" class="btn btn-task btn-outline-danger me-1" wire:click="confirmDelete" wire:loading.attr="disabled" wire:offline.attr="disabled">
                🗑
            </button>
            @endif
            @endif
            @if (Auth::user()->staffShip)
            <button type="button" class="btn btn-task {{ $question->hidden ? 'btn-danger' : 'btn-outline-danger' }} text-white" wire:click="hide" wire:loading.attr="disabled" wire:offline.attr="disabled" wire:key="{{ $question->id }}" title="Flag to admins">
                🤢
            </button>
            @endif
            @endauth
            @guest
                <a href="/login" class="btn btn-task btn-outline-success me-1">
                    👏
                    @if ($question->likerscount() !== 0)
                    <span class="small text-dark fw-bold">
                        {{ number_format($question->likerscount()) }}
                    </span>
                    <span class="avatar-stack ms-1">
                    @foreach($question->likers->take(5) as $user)
<<<<<<< HEAD
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 50) }}" alt="{{ $user->username }}'s avatar" />
=======
                    <img loading=lazy class="praise-avatar rounded-circle {{ $loop->last ? 'me-0' : '' }}" src="{{ Helper::getCDNImage($user->avatar, 80) }}" alt="{{ $user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                    @endforeach
                    </span>
                    @endif
                </a>
            @endguest
            @if (views($question)->remember()->count('id') > 0)
            <span class="align-middle ms-2 me-2">
                <x-heroicon-o-eye class="heroicon" />
                <span class="text-secondary">
                    <span class="fw-bold">{{ number_format(views($question)->remember()->unique()->count('id')) }}</span>
                    {{ views($question)->remember()->unique()->count('id') <= 1 ? 'View' : 'Views' }}
                </span>
            </span>
            @endif
            @if ($type !== "question.question")
            <a href="{{ route('question.question', ['id' => $question->id]) }}" class="avatar-stack text-dark">
                @foreach ($question->answer->groupBy('user_id')->take(5) as $answer)
<<<<<<< HEAD
                <img loading=lazy class="rounded-circle avatar avatar-30" src="{{ Helper::getCDNImage($answer[0]->user->avatar, 50) }}" alt="{{ $answer[0]->user->username }}'s avatar" />
=======
                <img loading=lazy class="rounded-circle avatar avatar-30" src="{{ Helper::getCDNImage($answer[0]->user->avatar, 80) }}" alt="{{ $answer[0]->user->username }}'s avatar" />
>>>>>>> b18e0c01a7a50af04ce03ea488741e1ccafd70c7
                @endforeach
                @if ($question->answer->groupBy('user_id')->count('id') >= 5)
                <span class="ms-3 ps-1 align-middle fw-bold small">
                    +{{ number_format($question->answer->groupBy('user_id')->count('id') - 5) }} more
                </span>
                @endif
            </a>
            @endif
        </div>
    </div>
</div>
