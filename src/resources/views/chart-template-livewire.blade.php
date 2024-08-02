<div>
    <div
        x-data="chart(@js($this->{$model}), {{ $options }} )"
        wire:loading.class="opacity-50"
    >
        <canvas width="@js($size['width'])" height="@js($size['height'])" wire:ignore></canvas>
    </div>
</div>

@assets
    @if($delivery == 'cdn')
        @if($version == 4)
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^4"></script>
            @if($date_adapter == 'moment')
                <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
            @elseif($date_adapter == 'luxon')
                <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
            @elseif($date_adapter == 'date-fns')
                <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
            @endif
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @elseif($version == 3)
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^3"></script>
            @if($date_adapter == 'moment')
                <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
            @elseif($date_adapter == 'luxon')
                <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
            @elseif($date_adapter == 'date-fns')
                <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
            @endif
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @else
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^2"></script>
            @if($date_adapter == 'moment')
                <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^0.1.2"></script>
            @elseif($date_adapter == 'luxon')
                <script src="https://cdn.jsdelivr.net/npm/luxon@^2"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1"></script>
            @elseif($date_adapter == 'date-fns')
                <script src="https://cdn.jsdelivr.net/npm/date-fns@^3/index.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
            @endif
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @endif
        @if(Config::get('chartjs.custom_chart_types'))
            @foreach(Config::get('chartjs.custom_chart_types') as $label => $cdn)
                <script src="{{ $cdn }}"></script>
            @endforeach
        @endif
    @elseif($delivery == 'publish')
        @if($version == 4)
            <script type="module" src="{{ asset('vendor/laravelchartjs/chart.js') }}"></script>
        @elseif($version == 3)
            <script src="{{ asset('vendor/laravelchartjs/chart3.js') }}"></script>
        @else
            <script src="{{ asset('vendor/laravelchartjs/chart2.bundle.js') }}"></script>
        @endif
    @elseif($delivery == 'binary')
        @if($version == 4)
            <script>{!! $chartJsScriptv4 !!}</script>
        @elseif($version == 3)
            <script>{!! $chartJsScriptv3 !!}</script>
        @else
            <script>{!! $chartJsScriptv2 !!}</script>
        @endif
    @endif
@endassets

@script
<script>
    Alpine.data('chart', Alpine.skipDuringClone((dataset, options) => {
        let chart

        return {
            init() {
                chart = this.initChart()
            },

            destroy() {
                chart.destroy()
            },

            initChart() {
                let el = this.$wire.$el.querySelector('canvas')

                let { labels, datasets } = dataset

                return new Chart(el, {
                    type: @js($type),
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