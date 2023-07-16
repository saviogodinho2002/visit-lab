<?php

namespace App\Filament\Resources\VisitGeralChartResource\Widgets;

use App\Models\Laboratory;
use App\Models\Visit;
use App\Utils\Util;
use Filament\Facades\Filament;
use Filament\Widgets\PieChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use PhpParser\Builder;

class MostVisitLaboratoryWeekChart extends PieChartWidget
{
    protected static ?string $heading = 'Visitas nos últimos  7 dias';

    protected function getData(): array
    {
        ;
        $currentDate = new \DateTime();
        $diff = $currentDate->getTimestamp() - 7 * 24 * 60 *60;
        $dateInitLastWeek =  new \DateTime();
        $dateInitLastWeek->setTimestamp($diff);
        //dd($currentDate->format("Y-m-d H:i:s"));
        $laboratorys = Laboratory::query()
                            ->withCount([
                                "visits"=>function ($query) use($dateInitLastWeek,$currentDate){
                                    $query->whereBetween("created_at",[ $dateInitLastWeek->format("Y-m-d H:i:s"),$currentDate->format("Y-m-d H:i:s") ]);
                                }
                            ])
                            ->get();
        //dd($laboratorys);
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
