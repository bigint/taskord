<div class="ssc">
    @for ($i = 0; $i < $count; $i++)
        <div class="d-flex align-items-center {{ ($i === 0 or $i === $count - 1) ? '' : 'my-3' }}">
            <div class="ssc-circle avatar-40"></div>
            <div class="w-70 ms-2">
                <div class="ssc-line w-70"></div>
                <div class="ssc-line"></div>
            </div>
        </div>
    @endfor
</div>
