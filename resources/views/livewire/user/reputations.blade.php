<div wire:init="loadReputations">
    <div class="card mb-4">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="card-body text-center mt-3 mb-3">
                    <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                    <div class="h6">
                        Loading points...
                    </div>
                </div>
            @endif
            @if ($readyToLoad and count($points) === 0)
                <div class="card-body text-center mt-3 mb-3">
                    <x-heroicon-o-sparkles class="heroicon heroicon-60px text-primary mb-2" />
                    <div class="h4">
                        No points awarded!
                    </div>
                </div>
            @endif
            @foreach ($points as $point)
                <div class="d-flex w-100 justify-content-between">
                    <div class="mb-1">
                        <x-heroicon-o-sparkles class="heroicon text-secondary me-2" />
                        <span class="fw-bold">{{ $point->point }}
                            {{ $point->point > 1 ? 'points' : 'point' }}</span>
                        @if ($point->name === 'TaskCreated')
                            earned for creating a new task 🆕
                        @endif
                        @if ($point->name === 'TaskCompleted')
                            earned for completing a task ✅
                        @endif
                        @if ($point->name === 'QuestionCreated')
                            earned for creating a new question ❓
                        @endif
                        @if ($point->name === 'CommentCreated')
                            earned for creating a new comment 💬
                        @endif
                        @if ($point->name === 'GoalReached')
                            earned for reaching the daily goal 🎯
                        @endif
                        @if ($point->name === 'LikeCreated')
                            @if ($point->subject_type === 'App\Models\Task')
                                earned for getting a like for your Task 👍
                            @endif
                            @if ($point->subject_type === 'App\Models\Comment')
                                earned for getting a like for your Comment 👍
                            @endif
                            @if ($point->subject_type === 'App\Models\Question')
                                earned for getting a like for your Question 👍
                            @endif
                            @if ($point->subject_type === 'App\Models\Answer')
                                earned for getting a like for your Answer 👍
                            @endif
                        @endif
                    </div>
                    <small class="text-secondary">{{ carbon($point->created_at)->diffForHumans() }}</small>
                </div>
                @if (!$loop->last)
                    <hr />
                @endif
            @endforeach
            <div class="mt-4">
                {{ $readyToLoad ? $points->links() : '' }}
            </div>
        </div>
    </div>
</div>
