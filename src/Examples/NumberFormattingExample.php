<?php

/*
 * Example demonstrating number formatting with Chart.js in Laravel ChartJS package
 * This addresses the issue where users want to format numbers in tooltips and axes
 */

namespace IcehouseVentures\LaravelChartjs\Examples;

use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class NumberFormattingExample
{
    /**
     * Creates a chart with Brazilian Portuguese number formatting
     * This example shows how to properly use optionsRaw() with JavaScript functions
     */
    public static function createFormattedChart()
    {
        $chart = Chartjs::build()
            ->name('formattedChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio'])
            ->datasets([
                [
                    'label' => 'Vendas (R$)',
                    'data' => [1234.56, 2345.67, 3456.78, 4567.89, 5678.90],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ]
            ])
            ->optionsRaw('{
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
            }');

        return $chart;
    }

    /**
     * Alternative approach using array-based options (will be JSON encoded)
     * Note: This approach cannot include JavaScript functions
     */
    public static function createSimpleFormattedChart()
    {
        $chart = Chartjs::build()
            ->name('simpleChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May'])
            ->datasets([
                [
                    'label' => 'Revenue',
                    'data' => [1000, 2000, 1500, 3000, 2500],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 2,
                    'fill' => false,
                ]
            ])
            ->options([
                'responsive' => true,
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                    ]
                ]
            ]);

        return $chart;
    }

    /**
     * Example for US dollar formatting
     */
    public static function createUSDollarChart()
    {
        $chart = Chartjs::build()
            ->name('usdChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Q1', 'Q2', 'Q3', 'Q4'])
            ->datasets([
                [
                    'label' => 'Revenue (USD)',
                    'data' => [12345.67, 23456.78, 34567.89, 45678.90],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ]
            ])
            ->optionsRaw('{
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
                                    label += "$" + context.parsed.y.toLocaleString("en-US", {
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
                                return "$" + value.toLocaleString("en-US", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                }
            }');

        return $chart;
    }
}