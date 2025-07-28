{{-- resources/views/charts/sales.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Sales Dashboard') }}</div>

                <div class="card-body">
                    <h4>Monthly Sales with Brazilian Real Formatting</h4>
                    <p>This chart demonstrates proper number formatting in tooltips and Y-axis labels.</p>
                    
                    {{-- Laravel ChartJS component --}}
                    <div style="width: 100%; max-width: 800px; margin: 0 auto;">
                        <x-chartjs-component :chart="$chart" />
                    </div>
                    
                    <div class="mt-4">
                        <h5>Features demonstrated:</h5>
                        <ul>
                            <li>✓ Brazilian Real currency formatting (R$ 1.234,56)</li>
                            <li>✓ Custom tooltip callbacks with locale-specific number formatting</li>
                            <li>✓ Y-axis tick formatting with currency symbols</li>
                            <li>✓ Responsive chart design</li>
                            <li>✓ Multi-dataset support</li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Technical Details:</h6>
                        <p>This chart uses the <code>optionsRaw()</code> method with JavaScript functions 
                           to format numbers using <code>toLocaleString("pt-BR")</code> for Brazilian 
                           Portuguese formatting with proper decimal places.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection