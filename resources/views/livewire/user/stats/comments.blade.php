<div class="mt-4" wire:init="loadComments">
    <h5>{{ $comments_count }} Comments</h5>
    <div class="card mt-3">
        <div class="card-body">
            @if (!$readyToLoad)
                <div class="card-body text-center mt-3">
                    <div class="spinner-border taskord-spinner text-secondary mb-3" role="status"></div>
                    <div class="h6">
                        Loading comments stats...
                    </div>
                </div>
            @endif
            <div id="comments"></div>
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
                    name: 'Comments',
                    data: <?php echo $comments; ?>
                }],
                xaxis: {
                    categories: <?php echo $week_dates; ?>,
                    labels: {
                        show: false
                    }
                }
            }

            var comments = new ApexCharts(document.querySelector("#comments"), options);
            comments.render();
        </script>
    @endif
</div>
