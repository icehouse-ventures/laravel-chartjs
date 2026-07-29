<div>
    <div
        x-data="chart({ type: @js($type) }, @js($this->{$model}), {{ $options }} )"
        wire:loading.class="opacity-50"
    >
        <canvas
            id="{{ $element }}"
            x-ref="canvas"
            width="{{ $size['width'] }}"
            height="{{ $size['height'] }}"
            wire:ignore
        ></canvas>
    </div>
</div>

@assets
    @include('laravelchartjs::chart-scripts')
@endassets

@script
<script>
    Alpine.data('chart', Alpine.skipDuringClone((config, dataset, options) => {
        let chart

        return {
            init() {
                chart = this.initChart()
            },

            destroy() {
                chart.destroy()
            },

            initChart() {
                const { type } = config

                const { labels, datasets } = dataset
                return new Chart(this.$refs.canvas, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: datasets,
                    },
                    options: options,
                })
            },
        }
    }))
</script>
@endscript
