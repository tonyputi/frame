<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;
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
        // $this->authorizeResource(Dashboard::class, 'dashboard');
    }

    public function __invoke(Request $request)
    {
        $collection = Environment::with(['locations' => function($query) {
            $query->select('id', 'environment_id', 'name');
        }])->get();

//        return $this->chartOptions($collection);

        return Inertia::render('Dashboard', [
            'charts' => $this->chartOptions($collection)
        ]);
    }

    protected function chartOptions($collection)
    {
        return $collection->map(function($environment) {
            $series = $environment->locations()->get()->map(function($location) {
                return [
                    'name' => $location->name,
                    'data' => $this->generateData(24, 0, 50)
                ];
            });

            return [
                'options' => [
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
                        'type' => 'category'
                    ],
                    'title' => [
                        'text' => $environment->name
                    ]
                ],
                'series' => $series
            ];
        });
    }

    protected function generateData($count, $min, $max)
    {
        $series = [];
        for($i = 0; $i < $count; $i++) {
            $x = (string)$i;
            $y = floor((mt_rand() / (mt_getrandmax() + 1)) * ($max - $min + 1)) + $min;
            array_push($series, compact('x', 'y'));
        }

        return $series;
    }
}
