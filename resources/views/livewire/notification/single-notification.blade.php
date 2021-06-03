<div>
    @php
        $user = \App\Models\User::find($data['user_id']);
        if (!$user or $user->is_suspended) {
            $user = \App\Models\User::whereUsername('ghost')->first();
        }
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                @if ($type !== "App\Notifications\Welcome")
                    <x:shared.user-label-small :user="$user" />
                @endif
                @if ($pageType === 'unread')
                    <button wire:click="markSingleNotificationAsRead" class="btn btn-sm btn-action ms-5" title="Mark as read">
                        <span wire:loading.remove wire:target="markSingleNotificationAsRead">
                            <x-heroicon-s-check class="heroicon heroicon-20px text-secondary me-0" />
                        </span>
                        <span wire:loading wire:target="markSingleNotificationAsRead" class="spinner-border spinner-border-sm"></span>
                    </button>
                @endif
            </div>
            @if ($type === "App\Notifications\Task\TaskPraised")
                <livewire:notification.type.task.task-praised :data="$data" />
            @elseif ($type === "App\Notifications\Mentioned")
                <livewire:notification.type.mentioned :data="$data" />
            @elseif ($type === "App\Notifications\Comment\CommentPraised")
                <livewire:notification.type.comment.comment-praised :data="$data" />
            @elseif ($type === "App\Notifications\Comment\Reply\ReplyPraised")
                <livewire:notification.type.comment.reply.reply-praised :data="$data" />
            @elseif ($type === "App\Notifications\Question\QuestionPraised")
                <livewire:notification.type.question.question-praised :data="$data" />
            @elseif ($type === "App\Notifications\Answer\AnswerPraised")
                <livewire:notification.type.answer.answer-praised :data="$data" />
            @elseif ($type === "App\Notifications\Comment\Commented")
                <livewire:notification.type.comment.commented :data="$data" />
            @elseif ($type === "App\Notifications\Answer\Answered")
                <livewire:notification.type.answer.answered :data="$data" />
            @elseif ($type === "App\Notifications\Product\Subscribed")
                <livewire:notification.type.product.subscribed :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberAdded")
                <livewire:notification.type.product.member-added :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberRemoved")
                <livewire:notification.type.product.member-removed :data="$data" />
            @elseif ($type === "App\Notifications\Product\MemberLeft")
                <livewire:notification.type.product.member-left :data="$data" />
            @elseif ($type === "App\Notifications\Task\NotifySubscribers")
                <livewire:notification.type.task.notify-subscribers :data="$data" />
            @elseif ($type === "App\Notifications\Question\NotifySubscribers")
                <livewire:notification.type.question.notify-subscribers :data="$data" />
            @elseif ($type === "App\Notifications\Comment\Reply\Replied")
                <livewire:notification.type.comment.reply.replied :data="$data" />
            @elseif ($type === "App\Notifications\Milestone\MilestonePraised")
                <livewire:notification.type.milestone.milestone-praised :data="$data" />
            @elseif ($type === "App\Notifications\Followed")
                <div class="mt-2 text-secondary">
                    followed you
                </div>
                <div class="mt-2">
                    @livewire('notification.follow', [
                        'user' => $user
                    ])
                </div>
            @elseif ($type === "App\Notifications\Welcome")
                <div class="mt-2 fw-bold">
                    Welcome to Taskord! 👋
                </div>
                <div class="mt-2">
                    <a href="{{ route('explore.explore') }}">Explore</a> what's happening on Taskord
                </div>
                <div class="mt-2">
                    Have a nice day 💜
                </div>
            @endif
            <div class="small mt-3 text-secondary">
                {{ carbon($createdAt)->diffForHumans() }}
            </div>
        </div>
    </div>
</div>
