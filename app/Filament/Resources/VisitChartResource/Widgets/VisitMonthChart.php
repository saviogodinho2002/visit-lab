<?php

namespace App\Filament\Resources\VisitChartResource\Widgets;

use App\Models\Visit;
use App\Utils\Util;
use Filament\Facades\Filament;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class VisitMonthChart extends LineChartWidget
{
    protected static ?string $heading = 'Visitas esse mês';

    protected function getData(): array
    {
        ;

        $laboratorys = Trend::query(
            Visit::query()
                ->where("laboratory_id","=",Filament::auth()->user()->laboratory_id)
        )
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();
        //dd($laboratorys);
        return [
            'datasets' => [
                [
                    'label' => 'Visitas em '.Filament::auth()->user()->laboratory->name,
                    //'title' => 'Visitas',
                    'data' => $laboratorys->map(fn (TrendValue $value) => $value->aggregate),
                    "borderColor"=> 'rgb(75, 192, 192)',
                    "backgroundColor" => Util::$collors,

                    "tension"=> 0.1
                ],
            ],
            'labels' => $laboratorys->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
