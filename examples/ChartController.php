<?php

/*
 * Complete working example for the user's issue
 * This demonstrates exactly how to implement number formatting in Laravel ChartJS
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class ChartController extends Controller
{
    /**
     * Brazilian Real number formatting example
     * This is exactly what the user was trying to achieve
     */
    public function brazilianNumberFormatting()
    {
        $chart = Chartjs::build()
            ->name('salesChart')
            ->type('bar')
            ->size(['width' => 600, 'height' => 400])
            ->labels(['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'])
            ->datasets([
                [
                    'label' => 'Vendas 2024',
                    'data' => [12345.67, 23456.78, 18945.32, 29876.43, 35467.89, 41234.56],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Vendas 2023',
                    'data' => [10234.56, 19876.54, 16543.21, 25432.10, 31098.76, 37654.32],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ]
            ])
            ->optionsRaw('{
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Vendas Mensais"
                    },
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
                        title: {
                            display: true,
                            text: "Valores (R$)"
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return "R$ " + value.toLocaleString("pt-BR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Meses"
                        }
                    }
                }
            }');

        return view('charts.sales', compact('chart'));
    }

    /**
     * US Dollar formatting example
     */
    public function usDollarFormatting()
    {
        $chart = Chartjs::build()
            ->name('revenueChart')
            ->type('line')
            ->size(['width' => 600, 'height' => 400])
            ->labels(['Q1', 'Q2', 'Q3', 'Q4'])
            ->datasets([
                [
                    'label' => 'Revenue 2024',
                    'data' => [125000.50, 187500.75, 156750.25, 234000.00],
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                    'fill' => false,
                ]
            ])
            ->optionsRaw('{
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Quarterly Revenue"
                    },
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
                        title: {
                            display: true,
                            text: "Revenue (USD)"
                        },
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

        return view('charts.revenue', compact('chart'));
    }

    /**
     * Alternative approach using quoted JSON syntax (user's original approach)
     * This also works perfectly fine
     */
    public function quotedSyntaxExample()
    {
        $chart = Chartjs::build()
            ->name('quotedChart')
            ->type('bar')
            ->size(['width' => 600, 'height' => 400])
            ->labels(['Jan', 'Feb', 'Mar'])
            ->datasets([
                [
                    'label' => 'Sales',
                    'data' => [1234.56, 2345.67, 3456.78],
                    'backgroundColor' => 'rgba(153, 102, 255, 0.6)',
                ]
            ])
            ->optionsRaw('{
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
            }');

        return view('charts.quoted-example', compact('chart'));
    }
}