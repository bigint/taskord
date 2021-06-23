<div class="mt-4" wire:init="loadReputations">
    <h5>{{ $reputations_count }} Reputations</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="card-body text-center mt-3">
                    <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                    <div class="h6">
                        Loading reputations stats...
                    </div>
                </div>
            @endif
            <div id="reputations"></div>
        </div>
    </div>

    @if ($readyToLoad)
        <script>
            var options = {
                chart: {
                    type: 'line',
                    height: 300,
                    animations: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: 'Reputations',
                    data: <?php echo $reputations; ?>
                }],
                xaxis: {
                    categories: <?php echo $week_dates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var reputations = new ApexCharts(document.querySelector("#reputations"), options);
            reputations.render();
        </script>
    @endif
</div>
