<div class="ssc">
    <ul class="list-group list-group-flush">
        @for ($i = 0; $i < $count; $i++)
            <li class="list-group-item py-3">
                <div class="d-flex align-items-center">
                    <div class="ssc-circle avatar-40"></div>
                    <div class="w-70 ms-2">
                        <div class="ssc-line w-20"></div>
                        <div class="ssc-line w-10"></div>
                    </div>
                    <div class="ssc-head-line w-10 ms-auto"></div>
                </div>
            </li>
        @endfor
    </ul>
</div>
