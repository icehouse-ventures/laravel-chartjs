<?php

use IcehouseVentures\LaravelChartjs\Builder;

test('it can handle raw JavaScript options with functions', function () {
    $builder = new Builder();
    
    // This is the actual user's code that's failing
    $rawOptionsWithFunctions = '{
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
    
    $result = $builder->name('chart1')->optionsRaw($rawOptionsWithFunctions);
    
    expect($result)->toBeInstanceOf(Builder::class);
    
    // Verify the options are stored correctly
    $storedOptions = $builder->get('optionsRaw');
    expect($storedOptions)->toBe($rawOptionsWithFunctions);
    expect($storedOptions)->toContain('function(context)');
    expect($storedOptions)->toContain('toLocaleString("pt-BR"');
    expect($storedOptions)->toContain('R$ ');
});

test('it can handle simple JSON options without functions', function () {
    $builder = new Builder();
    
    $simpleOptions = '{
        "responsive": true,
        "plugins": {
            "legend": {
                "display": false
            }
        }
    }';
    
    $result = $builder->name('chart2')->optionsRaw($simpleOptions);
    
    expect($result)->toBeInstanceOf(Builder::class);
    
    // Verify the options are stored correctly
    $storedOptions = $builder->get('optionsRaw');
    expect($storedOptions)->toBe($simpleOptions);
    expect($storedOptions)->toContain('"responsive": true');
    expect($storedOptions)->toContain('"display": false');
});

test('it handles array-based optionsRaw correctly', function () {
    $builder = new Builder();
    
    $arrayOptions = [
        'responsive' => true,
        'plugins' => [
            'legend' => [
                'display' => false
            ]
        ]
    ];
    
    $result = $builder->name('chart3')->optionsRaw($arrayOptions);
    
    expect($result)->toBeInstanceOf(Builder::class);
    
    // Should be JSON encoded
    $storedOptions = $builder->get('optionsRaw');
    expect($storedOptions)->toBeString();
    expect($storedOptions)->toContain('"responsive":true');
    expect($storedOptions)->toContain('"display":false');
});

test('it prioritizes optionsRaw over regular options', function () {
    $builder = new Builder();
    
    $builder->name('chart4')
        ->options(['responsive' => false])
        ->optionsRaw('{"responsive": true}');
    
    // optionsRaw should take precedence
    $storedRaw = $builder->get('optionsRaw');
    $storedRegular = $builder->get('options');
    
    expect($storedRaw)->toBe('{"responsive": true}');
    expect($storedRegular)->toHaveKey('responsive', false);
    
    // When rendering, optionsRaw should be used
    // Note: This would need a proper Laravel environment to test fully
});

test('it handles javascript functions in optionsRaw string', function () {
    $builder = new Builder();
    
    // Test with the user's exact formatting issue
    $jsWithFunctions = '{
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return "R$ " + context.parsed.y.toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }
        }
    }';
    
    $result = $builder->name('chart5')->optionsRaw($jsWithFunctions);
    
    expect($result)->toBeInstanceOf(Builder::class);
    
    $storedOptions = $builder->get('optionsRaw');
    expect($storedOptions)->toBe($jsWithFunctions);
    expect($storedOptions)->toContain('function(context)');
    expect($storedOptions)->toContain('toLocaleString("pt-BR"');
    expect($storedOptions)->toContain('minimumFractionDigits: 2');
});

test('it validates optionsRaw input format', function () {
    $builder = new Builder();
    
    // Should reject invalid input that doesn't start/end with braces
    expect(function() use ($builder) {
        $builder->name('invalid1')->optionsRaw('responsive: true');
    })->toThrow(InvalidArgumentException::class);
    
    // Should reject quoted functions
    expect(function() use ($builder) {
        $builder->name('invalid2')->optionsRaw('{"callback": "function() { return true; }"}');
    })->toThrow(InvalidArgumentException::class);
});

test('it accepts both quoted and unquoted property syntax', function () {
    $builder1 = new Builder();
    $builder2 = new Builder();
    
    // Quoted JSON-style properties (user's approach)
    $quotedSyntax = '{
        "responsive": true,
        "plugins": {
            "legend": {
                "display": false
            }
        }
    }';
    
    // Unquoted JavaScript object properties (README approach)  
    $unquotedSyntax = '{
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        }
    }';
    
    // Both should work
    expect(function() use ($builder1, $quotedSyntax) {
        $builder1->name('quoted')->optionsRaw($quotedSyntax);
    })->not->toThrow();
    
    expect(function() use ($builder2, $unquotedSyntax) {
        $builder2->name('unquoted')->optionsRaw($unquotedSyntax);
    })->not->toThrow();
});