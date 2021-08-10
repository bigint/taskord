<div class="ssc">
    <ul class="list-group list-group-flush">
        @for ($i = 0; $i < $count; $i++)
            <li class="list-group-item py-3 px-0">
                <div class="d-flex align-items-center">
                    <div class="ssc-circle avatar-20"></div>
                    <div class="w-70 ms-3">
                        <div class="ssc-line w-40"></div>
                    </div>
                    <div class="ssc-line w-10 m-0 ms-auto"></div>
                </div>
            </li>
        @endfor
    </ul>
</div>
