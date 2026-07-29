@once
    @include('laravelchartjs::chart-scripts')
@endonce

<canvas id="{{ $element }}" width="{{ $size['width'] }}" height="{{ $size['height'] }}"></canvas>
<script>
    (function() {
        var init = function() {
            "use strict";
            var element = @js($element);
            var ctx = document.getElementById(element);
            window[element] = new Chart(ctx, {
                type: @js($type),
                data: {
                    labels: {!! $labels !!},
                    datasets: {!! $datasets !!}
                },
                options: {!! $options !!}
            });
        };

        if (document.readyState !== 'loading') {
            init();
        } else {
            document.addEventListener("DOMContentLoaded", init);
        }
    })();
</script>
