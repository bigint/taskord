<span class="float-right">
    <input wire:click="onlyFollowingsTasks" id="onlyFollowingsTasks" class="form-check-input" type="checkbox" {{ Auth::user()->onlyFollowingsTasks ? 'checked' : '' }}>
    <label for="onlyFollowingsTasks" class="ml-1">
        Only following
    </label>
    <span wire:loading wire:target="onlyFollowingsTasks" class="small ml-2 spinner-border spinner-border-sm text-primary"></span>
    @include('components.beta', ['background' => 'light'])
</span>
