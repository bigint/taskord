<div wire:init="loadAllTasks">
    <h5>{{ $all_tasks_count }} Total Tasks</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="card-body text-center mt-3">
                    <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                    <div class="h6">
                        Loading all tasks stats...
                    </div>
                </div>
            @endif
            <div id="allTasks"></div>
        </div>
    </div>

    @if ($readyToLoad)
        <script>
            var options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    animations: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Tasks',
                    data: <?php echo $all_tasks; ?>
                }],
                xaxis: {
                    categories: <?php echo $week_dates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var allTasks = new ApexCharts(document.querySelector("#allTasks"), options);
            allTasks.render();
        </script>
    @endif
</div>
