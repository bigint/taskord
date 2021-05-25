<div class="d-flex justify-content-between">
    <span>Go to Homepage</span>
    <span>
        <kbd class="me-1">g</kbd><kbd>h</kbd>
    </span>
</div>
<div class="d-flex justify-content-between mt-2">
    <span>Go to user profile</span>
    <span>
        <kbd class="me-1">g</kbd><kbd>u</kbd>
    </span>
</div>
<div class="d-flex justify-content-between mt-2">
    <span>Go to products</span>
    <span>
        <kbd class="me-1">g</kbd><kbd>p</kbd>
    </span>
</div>
<div class="d-flex justify-content-between mt-2">
    <span>Go to questions</span>
    <span>
        <kbd class="me-1">g</kbd><kbd>q</kbd>
    </span>
</div>
@auth
    <div class="d-flex justify-content-between mt-2">
        <span>Go to notifications</span>
        <span>
            <kbd class="me-1">g</kbd><kbd>n</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Go to settings</span>
        <span>
            <kbd class="me-1">g</kbd><kbd>s</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Compose new task</span>
        <span>
            <kbd>n</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Create new product</span>
        <span>
            <kbd class="me-1">c</kbd><kbd>p</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Create new question</span>
        <span>
            <kbd class="me-1">c</kbd><kbd>q</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Create new milestone</span>
        <span>
            <kbd class="me-1">c</kbd><kbd>m</kbd>
        </span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Enable dark mode</span>
        <span>
            <kbd class="me-1">d</kbd><kbd>m</kbd>
        </span>
    </div>
    @if (auth()->user()->is_staff)
        <div class="d-flex justify-content-between mt-2">
            <span>Enable staff mode</span>
            <span>
                <kbd class="me-1">p</kbd><kbd>b</kbd> or
                <kbd>`</kbd>
            </span>
        </div>
        <div class="d-flex justify-content-between mt-2">
            <span>Bring up deploy dialog</span>
            <span>
                <kbd class="me-1">shift</kbd><kbd>d</kbd>
            </span>
        </div>
    @endif
@endauth
<div class="d-flex justify-content-between mt-2">
    <span>Bring up this help dialog</span>
    <span>
        <kbd>?</kbd>
    </span>
</div>
