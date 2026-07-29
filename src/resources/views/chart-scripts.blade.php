@if($delivery === 'cdn')
    @if($version >= 4)
        <script src="{{ 'https://cdn.jsdelivr.net/npm/chart.js@'.$version.'/dist/chart.umd.min.js' }}"></script>
    @elseif($version === 3)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
    @else
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2/dist/Chart.min.js"></script>
    @endif

    @if($date_adapter === 'moment')
        <script src="https://cdn.jsdelivr.net/npm/moment@2/min/moment.min.js"></script>
        <script src="{{ 'https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@'.($version >= 3 ? '1' : '0.1.2') }}"></script>
    @elseif($date_adapter === 'luxon')
        <script src="{{ 'https://cdn.jsdelivr.net/npm/luxon@'.($version >= 3 ? '3' : '1').'/build/global/luxon.min.js' }}"></script>
        <script src="{{ 'https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@'.($version >= 3 ? '1' : '0.2.1') }}"></script>
    @elseif($date_adapter === 'date-fns')
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/numeral@2/numeral.min.js"></script>

    @foreach(config('chartjs.custom_chart_types', []) as $cdn)
        <script src="{{ $cdn }}"></script>
    @endforeach
@elseif($delivery === 'publish')
    @if($version >= 4)
        <script src="{{ asset('vendor/laravelchartjs/chart.js') }}"></script>
    @elseif($version === 3)
        <script src="{{ asset('vendor/laravelchartjs/chart3.js') }}"></script>
    @else
        <script src="{{ asset('vendor/laravelchartjs/chart2.bundle.js') }}"></script>
    @endif
@elseif($delivery === 'binary')
    @if($version >= 4)
        <script>{!! $chartJsScriptv4 !!}</script>
    @elseif($version === 3)
        <script>{!! $chartJsScriptv3 !!}</script>
    @else
        <script>{!! $chartJsScriptv2 !!}</script>
    @endif
@endif
