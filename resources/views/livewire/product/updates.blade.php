<div>
    @if (count($updates) === 0)
    @include('components.empty', [
        'icon' => 'refresh',
        'text' => 'No updates made!',
    ])
    @endif
    @foreach ($updates as $update)
    <div class="card mb-4">
        <div class="card-header h6 pt-3 pb-3">
            <a href="">
                <img class="rounded-circle avatar-30" src="{{ $update->user->avatar }}" />
            </a>
            <a class="align-middle text-dark ml-2" href="">
                {{ $update->title }}
            </a>
        </div>
        <div class="card-body pb-0">
            @include('components.alert')
            <div>@markdown($update->body)</div>
        </div>
    </div>
    @endforeach
    {{ $updates->links() }}
</div>
