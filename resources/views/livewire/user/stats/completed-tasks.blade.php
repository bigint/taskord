<div class="mt-4" wire:init="loadCompletedTasks">
    <h5>{{ $completed_tasks_count }} Completed Tasks</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$ready_to_load)
                <div class="card-body text-center mt-3">
                    <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                    <div class="h6">
                        Loading completed tasks stats...
                    </div>
                </div>
            @endif
            <div id="completedTasks"></div>
        </div>
    </div>

    @if ($ready_to_load)
        <script>
        var options = {
            chart: { type: 'bar', height: 300, animations: { enabled: false }},
            dataLabels: { enabled: false },
            series: [{name: 'Tasks', data: <?php echo $completed_tasks ?> }],
            xaxis: { categories: <?php echo $week_dates ?>, labels: { show: false } }
        }

        var completedTasks = new ApexCharts(document.querySelector("#completedTasks"), options);
        completedTasks.render();
        </script>
    @endif
</div>
