<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
        if (!$user) {
            $user = \App\Models\User::where('username', 'ghost')->first();
        }
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <span class="fw-bold">
                @if (
                    $type === "App\Notifications\TaskPraised" or
                    $type === "App\Notifications\QuestionPraised" or
                    $type === "App\Notifications\AnswerPraised" or
                    $type === "App\Notifications\CommentPraised"
                )
                    👍
                @elseif ($type === "App\Notifications\Mentioned")
                    🙌
                @elseif (
                    $type === "App\Notifications\Followed" or
                    $type === "App\Notifications\Subscribed" or
                    $type === "App\Notifications\Product\MemberAdded"
                )
                    ➕
                @elseif (
                    $type === "App\Notifications\Commented" or
                    $type === "App\Notifications\Answered" or
                    $type === "App\Notifications\Task\NotifySubscribers" or
                    $type === "App\Notifications\Question\NotifySubscribers"
                )
                    💬
                @elseif (
                    $type === "App\Notifications\Product\MemberRemoved" or
                    $type === "App\Notifications\Product\MemberLeft"
                )
                    🚪
                @elseif (
                    $type === "App\Notifications\Welcome" or
                    $type === "App\Notifications\VersionReleased"
                )
                    🎉
                @endif
                @if ($type !== "App\Notifications\Welcome" and $type !== "App\Notifications\VersionReleased")
                <a href="{{ route('user.done', ['username' => $user->username]) }}">
                    <img loading=lazy class="rounded-circle avatar-20 ms-2 me-1" src="{{ Helper::getCDNImage($user->avatar, 80) }}" height="20" width="20" alt="{{ $user->username }}'s avatar" />
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
                <span class="align-middle">
                    praised your
                    <a class="fw-bold" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        task
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Purify::clean(Helper::renderTask($data['task'])) !!}
                </div>
            @elseif ($type === "App\Notifications\Mentioned")
                @if ($data['body_type'] === 'task')
                <span class="align-middle">
                    mentioned you in a
                    <a class="fw-bold" href="{{ route('task', ['id' => $data['body_id']]) }}">
                        task
                    </a>
                </span>
                @elseif ($data['body_type'] === 'comment')
                <span class="align-middle">
                    mentioned you in a
                    <a class="fw-bold" href="{{ route('comment', ['id' => $data['body_id'], 'comment_id' => $data['entity_id']]) }}">
                        comment
                    </a>
                </span>
                @elseif ($data['body_type'] === 'answer')
                <span class="align-middle">
                    mentioned you in an
                    <a class="fw-bold" href="{{ route('question.question', ['id' => $data['body_id']]) }}">
                        answer
                    </a>
                </span>
                @endif
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['body']) !!}
                </div>
            @elseif ($type === "App\Notifications\CommentPraised")
                <span class="align-middle">
                    praised your
                    <a class="fw-bold" href="{{ route('comment', ['id' => $data['task_id'], 'comment_id' => $data['comment_id']]) }}">
                        comment
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['comment']) !!}
                </div>
            @elseif ($type === "App\Notifications\QuestionPraised")
                <span class="align-middle">
                    praised your
                    <a class="fw-bold" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        question
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['question']) !!}
                </div>
            @elseif ($type === "App\Notifications\AnswerPraised")
                <span class="align-middle">
                    praised your
                    <a class="fw-bold" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        answer
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['answer']) !!}
                </div>
            @elseif ($type === "App\Notifications\Commented")
                <span class="align-middle">
                    commented on your
                    <a class="fw-bold" href="{{ route('comment', ['id' => $data['task_id'], 'comment_id' => $data['comment_id']]) }}">
                        task
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['comment']) !!}
                </div>
            @elseif ($type === "App\Notifications\Answered")
                <span class="align-middle">
                    answered to your
                    <a class="fw-bold" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        question
                    </a>
                </span>
                <div class="mt-2 body-font">
                    {!! Markdown::parse($data['answer']) !!}
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
                    <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberAdded")
                <span class="align-middle">
                    added you to the product
                    <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberRemoved")
                <span class="align-middle">
                    removed you from the product
                    <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Product\MemberLeft")
                <span class="align-middle">
                    left from the product
                    <a class="fw-bold" href="{{ route('product.done', ['slug' => \App\Models\Product::find($data['product_id'])->slug]) }}">
                        <img loading=lazy class="rounded avatar-20 ms-1 me-1" src="{{ Helper::getCDNImage(\App\Models\Product::find($data['product_id'])->avatar, 80) }}" height="20" width="20" />
                        {{ \App\Models\Product::find($data['product_id'])->name }}
                    </a>
                </span>
            @elseif ($type === "App\Notifications\Welcome")
                <span class="ms-1 fw-bold">
                    Welcome to Taskord
                </span>
            @elseif ($type === "App\Notifications\VersionReleased")
                <span class="ms-1 fw-bold">
                    Version {{ $data['tagName'] }} has been released!
                </span>
                <div class="mt-3">
                    <span class="fw-bold">Changelog</span>
                    <div class="mt-2">
                        {!! Markdown::parse($data['description']) !!}
                    </div>
                </div>
            @elseif ($type === "App\Notifications\Task\NotifySubscribers")
                <span class="align-middle">
                    commented on a
                    <a class="fw-bold" href="{{ route('task', ['id' => $data['task_id']]) }}">
                        task
                    </a>
                    you subscribed
                    <div class="mt-2 body-font">
                        {!! nl2br(Purify::clean(Helper::renderTask($data['comment']))) !!}
                    </div>
                </span>
            @elseif ($type === "App\Notifications\Question\NotifySubscribers")
                <span class="align-middle">
                    answered to the
                    <a class="fw-bold" href="{{ route('question.question', ['id' => $data['question_id']]) }}">
                        question
                    </a>
                    you subscribed
                    <div class="mt-2 body-font">
                        {!! Markdown::parse($data['answer']) !!}
                    </div>
                </span>
            @endif
            <div class="small mt-2 text-secondary">
                {{ Carbon::createFromTimeStamp(strtotime($created_at))->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
