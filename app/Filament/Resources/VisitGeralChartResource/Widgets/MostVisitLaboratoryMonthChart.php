<?php

namespace App\Filament\Resources\VisitGeralChartResource\Widgets;

use App\Models\Laboratory;
use App\Utils\Util;
use Filament\Widgets\PieChartWidget;

class MostVisitLaboratoryMonthChart extends PieChartWidget
{
    protected static ?string $heading = 'Visitas nesse ano';

    protected function getData(): array
    {

        $currentDate = new \DateTime();
        $laboratorys = Laboratory::query()
            ->withCount([
                "visits"=>function ($query) use($currentDate){
                    $query->whereBetween("created_at",[ $currentDate->format("Y")."-01-01",( (int)$currentDate->format("Y")+1)."-01-01" ]);
                }
            ])
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Visitas em Laboratóris na última semana',
                    //'title' => 'Visitas',
                    'data' => $laboratorys->map(fn ( $value) => $value->visits_count),
                    "borderColor" => 'rgb(155, 192, 192)',
                    "backgroundColor" => Util::$collors,

                    "tension"=> 0.1
                ],
            ],
            'labels' => $laboratorys->map(fn ( $value) => $value->name),
        ];
    }
}
