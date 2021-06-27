<div wire:init="loadAnswers">
    @if (!$readyToLoad)
        <div class="mt-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
        <div class="mt-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
        <div class="mt-3 mb-3">
            <x:loaders.reply-skeleton count="1" />
        </div>
    @else
        @if (count($answers) === 0)
            <div class="card-body text-center mt-3 mb-3">
                <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
                <div class="h4">
                    No answers found!
                </div>
            </div>
        @endif
        @foreach ($answers as $answer)
            <div class="mb-3">
                <livewire:answer.single-answer :answer="$answer" :wire:key="$answer->id" />
            </div>
        @endforeach
        <div class="mt-3">
            @if ($answers->hasMorePages())
                <livewire:answer.load-more :question="$answer->question" :page="$page" :perPage="$perPage" />
            @endif
        </div>
    @endif
</div>
