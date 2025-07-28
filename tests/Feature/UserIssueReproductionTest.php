<?php

use IcehouseVentures\LaravelChartjs\Builder;

test('user issue reproduction - brazilian number formatting', function () {
    $builder = new Builder();
    
    // Exact code from the user's issue
    $userOptionsRaw = '{
                "responsive": true,
                "plugins": {
                    "tooltip": {
                        "callbacks": {
                            "label": function(context) {
                                let label = context.dataset.label || "";
                                if (label) {
                                    label += ": ";
                                }
                                if (context.parsed.y !== null) {
                                    label += "R$ " + context.parsed.y.toLocaleString("pt-BR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                                return label;
                            }
                        }
                    }
                },
                "scales": {
                    "y": {
                        "ticks": {
                            "callback": function(value, index, values) {
                                return "R$ " + value.toLocaleString("pt-BR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }
            }';
    
    // This should work without throwing any exceptions
    $chart = $builder
        ->name('userChart')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Janeiro', 'Fevereiro', 'Março'])
        ->datasets([
            [
                'label' => 'Vendas',
                'data' => [1234.56, 2345.67, 3456.78],
                'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1
            ]
        ])
        ->optionsRaw($userOptionsRaw);
    
    expect($chart)->toBeInstanceOf(Builder::class);
    
    // Verify the options are stored correctly 
    $storedOptions = $chart->get('optionsRaw');
    expect($storedOptions)->toBe($userOptionsRaw);
    
    // Verify it contains the formatting functions
    expect($storedOptions)->toContain('function(context)');
    expect($storedOptions)->toContain('function(value, index, values)');
    expect($storedOptions)->toContain('toLocaleString("pt-BR"');
    expect($storedOptions)->toContain('minimumFractionDigits: 2');
    expect($storedOptions)->toContain('maximumFractionDigits: 2');
    expect($storedOptions)->toContain('R$ ');
});

test('working number formatting examples', function () {
    $builder = new Builder();
    
    // Example using unquoted syntax (recommended)
    $recommendedSyntax = '{
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || "";
                        if (label) {
                            label += ": ";
                        }
                        if (context.parsed.y !== null) {
                            label += "R$ " + context.parsed.y.toLocaleString("pt-BR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }
        }
    }';
    
    $chart = $builder
        ->name('recommendedChart')
        ->type('line')
        ->optionsRaw($recommendedSyntax);
    
    expect($chart)->toBeInstanceOf(Builder::class);
    
    $storedOptions = $chart->get('optionsRaw');
    expect($storedOptions)->toBe($recommendedSyntax);
    expect($storedOptions)->toContain('beginAtZero: true');
});