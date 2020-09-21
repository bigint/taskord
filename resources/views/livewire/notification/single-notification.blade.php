<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
        if (!$user) {
            $user = \App\Models\User::where('username', 'ghost')->first();
        }
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
                    $type === "App\Notifications\Subscribed" or
                    $type === "App\Notifications\Product\MemberAdded"
                )
                    {{ Emoji::plus() }}
                @elseif (
                    $type === "App\Notifications\Commented" or
                    $type === "App\Notifications\Answered"
                )
                    {{ Emoji::speechBalloon() }}
                @elseif (
                    $type === "App\Notifications\Product\MemberRemoved" or
                    $type === "App\Notifications\Product\MemberLeft"
                )
                    {{ Emoji::door() }}
                @elseif (
                    $type === "App\Notifications\Welcome"
                )
                    {{ Emoji::partyPopper() }}
                @endif
                @if ($type !== "App\Notifications\Welcome")
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
                @endif
            </span>
            @if ($type === "App\Notifications\TaskPraised")
                <span class="align-middle">praised your task</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {!! Purify::clean(Helper::renderTask($data['task'])) !!}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\TaskMentioned")
                @if ($data['body_type'] === 'task')
                <span class="align-middle">mentioned you in a task</span>
                @endif
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['body_id']]) }}">
                        {!! Purify::clean(Helper::renderTask($data['body'])) !!}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\CommentPraised")
                <span class="align-middle">praised your task comment</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {!! nl2br(Purify::clean(Helper::renderTask($data['comment']))) !!}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\QuestionPraised")
                <span class="align-middle">praised your question</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        @markdown($data['question'])
                    </a>
                </div>
            @elseif ($type === "App\Notifications\AnswerPraised")
                <span class="align-middle">praised your answer</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        {!! nl2br(Purify::clean(Helper::renderTask($data['answer']))) !!}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\Commented")
                <span class="align-middle">commented on your task</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        {!! nl2br(Purify::clean(Helper::renderTask($data['comment']))) !!}
                    </a>
                </div>
            @elseif ($type === "App\Notifications\Answered")
                <span class="align-middle">answered to your question</span>
                <div class="mt-2 body-font">
                    <a class="text-dark" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        {!! nl2br(Purify::clean(Helper::renderTask($data['answer']))) !!}
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
                        <img class="rounded avatar-20 ml-1 mr-1" src="{{ \App\Models\Product::find($data['product_id'])->avatar }}" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberAdded")
                <span class="align-middle">
                    added you to the product
                    <a class="font-weight-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img class="rounded avatar-20 ml-1 mr-1" src="{{ \App\Models\Product::find($data['product_id'])->avatar }}" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberRemoved")
                <span class="align-middle">
                    removed you from the product
                    <a class="font-weight-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img class="rounded avatar-20 ml-1 mr-1" src="{{ \App\Models\Product::find($data['product_id'])->avatar }}" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberLeft")
                <span class="align-middle">
                    left from the product
                    <a class="font-weight-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img class="rounded avatar-20 ml-1 mr-1" src="{{ \App\Models\Product::find($data['product_id'])->avatar }}" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Welcome")
                <span class="ml-1 font-weight-bold">
                    Welcome to Taskord
                </span>
            @endif
            <div class="small mt-2 text-secondary">
                {{ Carbon::createFromTimeStamp(strtotime($created_at))->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
