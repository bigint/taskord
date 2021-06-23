<div wire:init="loadGraph">
    @if (!$readyToLoad)
        <div class="card-body">
            <div class="spinner-border spinner-border-sm taskord-spinner text-secondary me-2" role="status"></div>
            Loading activity graph...
        </div>
    @else
        @if ($count === 0)
            <div class="card-body">
                This user has no activity
            </div>
        @else
            <div id="activityGraph"></div>
        @endif
    @endif
    @if ($readyToLoad)
        <script>
            var options = {
                chart: {
                    type: 'area',
                    height: 100,
                    animations: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ["#198754"],
                stroke: {
                    width: [2, 1],
                    curve: 'smooth'
                },
                tooltip: {
                    enabled: false
                },
                grid: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Tasks',
                    data: <?php echo $tasks; ?>
                }],
                xaxis: {
                    categories: <?php echo $week_dates; ?>,
                    labels: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                }
            }

            var activityGraph = new ApexCharts(document.querySelector("#activityGraph"), options);
            activityGraph.render();
        </script>
    @endif
</div>
