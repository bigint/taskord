<div>
    @if (count($updates) === 0)
    <x-empty icon="refresh" text="No updates made"/>
    @endif
    @foreach ($updates as $update)
        @livewire('product.update.single-update', [
            'update' => $update,
        ])
    @endforeach
    {{ $updates->links() }}
</div>
