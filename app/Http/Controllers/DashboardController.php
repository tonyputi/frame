<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Dashboard::class, 'dashboard');
    }

    public function __invoke(Request $request)
    {
        $collection = Environment::with(['locations' => function($query) {
            $query->select('id', 'environment_id', 'name');
        }])->get();

        // return $this->chartOptions($collection);

        return Inertia::render('Dashboard', [
            'charts' => $this->chartOptions($collection)
        ]);
    }

    /**
     * Return heatmap chart options
     *
     * @param $collection
     * @return mixed
     */
    protected function chartOptions($collection)
    {
        return $collection->map(function($environment) {
            $series = $environment->locations()->get()->map(function($location) {
                return [
                    'name' => $location->name,
                    'data' => $this->getSerie($location)
                ];
            });

            return [
                'options' => [
                    'plotOptions' => [
                        'heatmap' => [
                            'colorScale' => [
                                'ranges' => [
                                    ['from' => 0, 'to' => 0, 'color' => '#00A100', 'name' => __('Low')],
                                    ['from' => 1, 'to' => 2, 'color' => '#128FD9', 'name' => __('Normal')],
                                    ['from' => 3, 'to' => 45, 'color' => '#990000', 'name' => __('High')]
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
                        // 'categories' => [
                        //     "00:00",
                        //     "00:30",
                        //     "11:00",
                        //     "11:30",
                        //     "12:00",
                        //     "12:30",
                        //     "01:00",
                        //     "01:30"
                        // ]
                    ],
                    'title' => [
                        'text' => $environment->name
                    ]
                ],
                'series' => $series
            ];
        });
    }


    /**
     * Generate heatmap serie
     *
     * @param Location $location
     * @return array
     */
    protected function getSerie(Location $location)
    {
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

        return $data;
    }
}
