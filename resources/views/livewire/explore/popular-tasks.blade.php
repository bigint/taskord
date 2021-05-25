<div wire:init="loadPopularTasks">
    @if (!$ready_to_load)
        <div class="card-body text-center mt-3 mb-3">
            <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
            <div class="h6">
                Loading popular tasks...
            </div>
        </div>
    @endif
    @foreach ($tasks as $task)
        <div class="card mb-3">
            <span class="p-3">
                <livewire:task.single-task :task="$task" :wire:key="$task->id" />
            </span>
        </div>
    @endforeach
    @if ($ready_to_load)
        <div class="text-center">
            <img class="avatar-100 my-3" src="https://ik.imagekit.io/taskordimg/tada_UEF5fl7T3.png" loading=lazy />
            <h4>
                That's everything we found for you, for now.
            </h4>
            <p>
                Come back soon to see what we find next.
            </p>
        </div>
    @endif
</div>
