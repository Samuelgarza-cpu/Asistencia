<?php

namespace App\Charts;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class Reports extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function chart_reports_example($data){
        
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"
        ];
        $chart = new Chart;
        $typeChart = 'bar';

        foreach($data as $value)
        {
            
            $dataSupports = [$value];
            $chart->dataset("hola", $typeChart, $dataSupports)->options([
                'color' =>'#00000',
                'label' => "Revenue",
                'backgroundColor' => $fillColors,
                'hoverBackgroundColor' => $borderColors,
                'borderColor' => $borderColors
            ]);
        };
        $chart->labels(["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);
        
        // $chart->dataset('My dataset 2', 'bar', [4, 3, 2, 1]);
        $chart->options([
            'tooltip' => [
                'show' => true, // or false, depending on what you want.
                'callbacks' =>[
                    'label' => function($tooltipItem, $chart) {
                        $datasetLabel = $chart.datasets[$tooltipItem.datasetIndex].label || '';
                        return $datasetLabel.': $'.number_format($tooltipItem.yLabel);
                    }
                ],
                'borderColor' => '#dddfeb',
                'titleMarginBottom' => 10,
                'titleFontColor' => '#6e707e',
                'titleFontSize' => 14,
                'backgroundColor' => "rgb(255,255,255)",
                'bodyFontColor' => "#858796"
            ],
            'scales'=> [
                'xAxes'=> [[
                    'time'=> [
                        'unit'=> 'month'
                    ],
                    'gridLines'=> [
                        'display'=> false,
                        'drawBorder'=> false
                    ],
                    // 'ticks'=> [
                    //     'maxTicksLimit'=> 6
                    // ],
                    // 'maxBarThickness'=> 25,
                ]],
                'yAxes'=> [[
                    'ticks'=> [
                        'min'=> 0,
                        // 'max'=> 15000,
                        // 'maxTicksLimit'=> 5,
                        'padding'=> 10
                    ],
                    'gridLines'=> [
                        // 'color'=> "rgb(234, 236, 244)",
                        // 'zeroLineColor'=> "rgb(234, 236, 244)",
                        'drawBorder'=> false,
                        'display'=> false,
                        // 'borderDash'=> [2],
                        // 'zeroLineBorderDash'=> [2]
                    ]
                ]],
            ],
        ]);
        $chart->displayLegend(false);
        $chart->displayAxes(true, false);
        $chart->title("Solicitudes", 14, "#4e73df", false, "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif");
        return $chart;
    }
}
