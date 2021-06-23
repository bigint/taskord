<div>
    @if (count($updates) === 0)
        <div class="card-body text-center mt-3 mb-3">
            <x-heroicon-o-refresh class="heroicon heroicon-60px text-primary mb-2" />
            <div class="h4">
                No updates made!
            </div>
        </div>
    @endif
    @foreach ($updates as $update)
        @livewire('product.update.single-update', ['update' => $update])
    @endforeach
    {{ $updates->links() }}
</div>
