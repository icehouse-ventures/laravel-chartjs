@if(config('chart-js.build') == 'CDN')
    @once
        @if($version == 4)
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^4"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @elseif($version == 3)
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^3"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @else
            <script src="https://cdn.jsdelivr.net/npm/chart.js@^2"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
            <script src="https://cdn.jsdelivr.net/npm/numeral@2.0.6/numeral.min.js"></script>
        @endif
    @endonce
@endif

<canvas id="{!! $element !!}" width="{!! $size['width'] !!}" height="{!! $size['height'] !!}">
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        (function() {
    		"use strict";
            var ctx = document.getElementById("{!! $element !!}");
            window.{!! $element !!} = new Chart(ctx, {
                type: '{!! $type !!}',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: {!! json_encode($datasets) !!}
                },
                @if(!empty($optionsRaw))
                    options: {!! $optionsRaw !!}
                @elseif(!empty($options))
                    options: {!! json_encode($options) !!}
                @endif
            });
        })();
    });
</script>
</canvas>