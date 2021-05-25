<div wire:init="loadAnswers">
    @if (!$ready_to_load)
        <div class="card-body text-center mt-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading answers...
            </div>
        </div>
    @endif
    @if ($ready_to_load and count($answers) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-chat-alt-2 class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No answers found!
            </div>
        </div>
    @endif
    @foreach ($answers as $answer)
        <div class="card mt-3">
            <livewire:answer.single-answer :answer="$answer" :wire:key="$answer->id" />
        </div>
    @endforeach
    <div class="mt-3">
        @if ($ready_to_load and $answers->hasMorePages())
            <livewire:answer.load-more :question="$answer->question" :page="$page" :perPage="$perPage" />
        @endif
    </div>
</div>
