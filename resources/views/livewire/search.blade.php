<div class="d-none d-md-block mr-3">
    <input
        type="text"
        id="search-input"
        class="form-control border-0 bg-secondary text-white"
        placeholder="Search Taskord..."
        wire:model="query"
    />
    <ul class="position-absolute mt-2 w-50 list-group shadow-sm search-dropdown" style="z-index:2">
        @if (!empty($query))
        <li class="list-group-item">
            <span class="h5">Tasks</span>
        </li>
        @if (count($tasks) > 0)
            @foreach ($tasks as $task)
            <li class="list-group-item">
                <span>
                    <input
                        class="form-check-input mt-1"
                        type="checkbox"
                        {{ $task->done ? "checked" : "unchecked" }}
                        disabled
                    />
                    <a class="ml-1 task-font text-dark" href="#">{{ $task->task }}</a>
                    <span class="small ml-2">👏
                        <span class="text-black-50">{{ $task->task_praise->count('id') }}</span>
                    </span>
                </span>
                <a href="{{ route('user.done', ['username' => $task->user->username]) }}">
                    <img class="rounded-circle float-right avatar-30" src="{{ $task->user->avatar }}" />
                </a>
            </li>
            @endforeach
        @else
            <li class="list-group-item">We couldn’t find any tasks matching <span class="font-weight-bold">{{ $query }}</span>!</li>
        @endif
        <li class="list-group-item">
            <span class="h5">Users</span>
        </li>
        @if (count($users) > 0)
            @foreach ($users as $user)
            <li class="list-group-item">
                <img class="rounded-circle avatar-30" src="{{ $user->avatar }}" />
                <span>
                    <a class="ml-2 task-font text-dark align-middle" href="{{ route('user.done', ['username' => $user->username]) }}">
                        <span class="font-weight-bold">
                            @if ($user->firstname or $user->lastname)
                                {{ $user->firstname }}{{ ' '.$user->lastname }}
                            @else
                                {{ $user->username }}
                            @endif
                        </span>
                        <span class="small">{{ "@" . $user->username }}</span>
                    </a>
                </span>
            </li>
            @endforeach
        @else
            <li class="list-group-item">We couldn’t find any users matching <span class="font-weight-bold">{{ $query }}</span>!</li>
        @endif
        <li class="list-group-item">
            <span class="h5">Products</span>
        </li>
        @if (count($products) > 0)
            @foreach ($products as $product)
            <li class="list-group-item">
                <img class="rounded avatar-30" src="{{ $product->avatar }}" />
                <span>
                    <a class="ml-2 task-font text-dark align-middle" href="{{ route('product.done', ['slug' => $product->slug]) }}">
                        <span class="font-weight-bold">{{ $product->name }}</span>
                    </a>
                </span>
                <a href="{{ route('user.done', ['username' => $product->user->username]) }}">
                    <img class="rounded-circle float-right avatar-30" src="{{ $product->user->avatar }}" />
                </a>
            </li>
            @endforeach
        @else
            <li class="list-group-item">We couldn’t find any products matching <span class="font-weight-bold">{{ $query }}</span>!</li>
        @endif
        <li class="list-group-item">
            <span class="h5">Questions</span>
        </li>
        @if (count($questions) > 0)
            @foreach ($questions as $question)
            <li class="list-group-item">
                <span>
                    <a class="ml-2 task-font text-dark" href="{{ route('question.question', ['id' => $question->id]) }}">
                        <span class="font-weight-bold">{{ Str::words($question->title, '8') }}</span>
                    </a>
                </span>
                <a href="{{ route('user.done', ['username' => $question->user->username]) }}">
                    <img class="rounded-circle float-right avatar-30" src="{{ $question->user->avatar }}" />
                </a>
            </li>
            @endforeach
        @else
            <li class="list-group-item">We couldn’t find any questions matching <span class="font-weight-bold">{{ $query }}</span>!</li>
        @endif
        @endif
    </ul>
</div>
