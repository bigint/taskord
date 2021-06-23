<div class="ssc">
    @for ($i = 0; $i < $count; $i++)
        <div class="{{ ($i === 0 or $i === $count - 1) ? '' : 'my-3' }}">
            <div class="d-flex align-items-center">
                <div class="ssc-circle rounded avatar-30"></div>
                <div class="w-70 ms-3">
                    <div class="ssc-line w-70"></div>
                </div>
                <div class="ssc-circle avatar-30 ms-auto"></div>
            </div>
        </div>
    @endfor
</div>
