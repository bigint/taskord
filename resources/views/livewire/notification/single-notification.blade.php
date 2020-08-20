<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <span class="font-weight-bold">
                @if (
                    $type === "App\Notifications\TaskPraised" or
                    $type === "App\Notifications\QuestionPraised" or
                    $type === "App\Notifications\AnswerPraised" or
                    $type === "App\Notifications\CommentPraised"
                )
                    {{ Emoji::clappingHands() }}
                @elseif ($type === "App\Notifications\TaskMentioned")
                    {{ Emoji::raisedHand() }}
                @elseif (
                    $type === "App\Notifications\Followed" or
                    $type === "App\Notifications\Subscribed"
                )
                    {{ Emoji::plusSign() }}
                @elseif (
                    $type === "App\Notifications\Commented" or
                    $type === "App\Notifications\Answered"
                )
                    {{ Emoji::speechBalloon() }}
                @endif
                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                    <img class="rounded-circle avatar-20 ml-2 mr-1" src="{{ $user->avatar }}" />
                    <span class="align-middle">
                        @if ($user->firstname or $user->lastname)
                            {{ $user->firstname }}{{ ' '.$user->lastname }}
                        @else
                            {{ $user->username }}
                        @endif
                    </span>
                </a>
            </span>
            @if ($type === "App\Notifications\TaskPraised")
                <span class="align-middle">praised your task</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {{ $data['task'] }}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\TaskMentioned")
                <span class="align-middle">mentioned you in a task</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {{ $data['task'] }}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\CommentPraised")
                <span class="align-middle">praised your task comment</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {{ $data['comment'] }}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\QuestionPraised")
                <span class="align-middle">praised your question</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        {{ $data['question'] }}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\AnswerPraised")
                <span class="align-middle">praised your answer</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        {{ $data['answer'] }}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\Commented")
                <span class="align-middle">commented on your task</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        @markdown($data['comment'])
                    </a>
                </div>
            @elseif ($type === "App\Notifications\Answered")
                <span class="align-middle">answered to your question</span>
                <div class="font-weight-bold mt-2">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        @markdown($data['answer'])
                    </a>
                </div>
            @elseif ($type === "App\Notifications\Followed")
                <span class="align-middle">followed you</span>
                <div class="mt-2">
                    @livewire('notification.follow', [
                        'user' => $user
                    ])
                </div>
            @elseif ($type === "App\Notifications\Subscribed")
                <span class="align-middle">
                    subscribed to your product
                    <a class="font-weight-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img class="rounded avatar-20 ml-2 mr-1" src="{{ \App\Models\Product::find($data['product_id'])->avatar }}" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @endif
            <div class="small mt-2 text-secondary">
                {{ Carbon::createFromTimeStamp(strtotime($created_at))->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
