<div>
    <h5>Completed Tasks</h5>
    <div class="card mt-3">
        <div class="card-body">
            <div id="completedTasks"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    var options = {
        chart: { type: 'bar' },
        series: [{ data: [30,40,45,50,49,60,70,91,125] }],
        xaxis: { categories: <?php echo $week_dates; ?> }
    }

    var completedTasks = new ApexCharts(document.querySelector("#completedTasks"), options);
    completedTasks.render();
    </script>
</div>
