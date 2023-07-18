<?php

namespace App\Filament\Resources\VisitChartResource\Widgets;

use App\Models\Laboratory;
use App\Models\Visit;
use App\Utils\Util;
use Faker\Core\DateTime;
use Filament\Facades\Filament;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Date;

class VisitWeekChart extends LineChartWidget
{
    protected static ?string $heading = 'Visitas nos últimos  7 dias';

    protected function getData(): array
    {
        ;
        $currentDate = new \DateTime();
        $currentDate = $currentDate->setTimezone(new \DateTimeZone("America/Santarem"));
        $diff = $currentDate->getTimestamp() - 7 * 24 * 60 *60;
        $dateInitLastWeek =  new \DateTime();
        $dateInitLastWeek->setTimestamp($diff);
        $dateInitLastWeek->format("d-m-Y-H-i-s");
        $visits = Trend::query(
            Visit::query()
                ->where("laboratory_id","=",Filament::auth()->user()->laboratory_id)
            )
            ->between(
                start: now()->setTimestamp($dateInitLastWeek->getTimestamp()),
                end: now()->endOfDay(),
            )
            ->perDay()
            ->count() ;
        //dd($laboratorys);
        return [
            'datasets' => [
                [
                    'label' => 'Visitas em '.Filament::auth()->user()->laboratory->name,
                    //'title' => 'Visitas',
                    'data' => $visits->map(fn (TrendValue $value) => $value->aggregate),
                    "borderColor"=> 'rgb(75, 192, 192)',
                    "backgroundColor" => Util::$collors,
                    "tension"=> 0.1
                ],
            ],
            'labels' => $visits->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
