<div>
    @if (count($updates) === 0)
    @include('components.empty', [
        'icon' => 'refresh',
        'text' => 'No updates made',
    ])
    @endif
    @foreach ($updates as $update)
        @livewire('product.update.single-update', [
            'update' => $update,
        ])
    @endforeach
    {{ $updates->links() }}
</div>
