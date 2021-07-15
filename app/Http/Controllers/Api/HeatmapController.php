<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HeatmapController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Environment $environment)
    {
        return response()->json([
            'options' => $this->options($request, $environment),
            'series' => $this->series($request, $environment)
        ]);
    }

    /**
     * Return the apex heatmap options
     *
     * @param Request     $request
     * @param Environment $environment
     * @return array
     */
    protected function options(Request $request, Environment $environment)
    {
        return [
            'plotOptions' => [
                'heatmap' => [
                    'distributed' => true,
                    'colorScale' => [
                        'ranges' => [
                            ['from' => 0, 'to' => 0, 'color' => '#00A100', 'name' => __('Low')],
                            ['from' => 1, 'to' => 3, 'color' => '#FFBF00', 'name' => __('Normal')],
                            ['from' => 4, 'to' => 100, 'color' => '#990000', 'name' => __('High')]
                        ]
                    ]
                ]
            ],
            'chart' => [
                'toolbar' => [
                    'show' => false
                ]
            ],
            'dataLabels' => [
                'enabled' => true
            ],
            'colors' => ['#008FFB'],
            'xaxis' => [
                'type' => 'category',
            ],
            'title' => [
                'text' => $environment->name
            ]
        ];
    }

    /**
     * Generate heatmap serie
     *
     * @param Environment $location
     * @return array
     */
    protected function series(Request $request, Environment $environment)
    {
        return $environment->locations->map(function($location) {
            $data = [];

            for ($i = 0; $i < 24; $i++) {
                $data[$i] = 0;
            }

            $query = $location->bookings();
            $query->selectRaw("strftime('%H', started_at) as x");
            $query->selectRaw("count('id') as y");
            $query->whereBetween('started_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()]);
            $query->groupBy('hour');

            // THIS IS VERY UGLY fin better solution
            $query->pluck('y', 'x')->each(function($e, $k) use (&$data, $location) {
                $data[(int)$k] = (int)$e;
            });

            return [
                'name' => $location->name,
                'data' => $data
            ];
        });
    }
}
