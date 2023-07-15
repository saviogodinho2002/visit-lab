<?php

namespace App\Filament\Pages;


use App\Filament\Resources\VisitCharResource\Widgets\VisitMonthChart;
use App\Filament\Resources\VisitCharResource\Widgets\VisitWeekChart;
use App\Filament\Resources\VisitCharResource\Widgets\VisitYearByMonthChart;
use Filament\Pages\Page;

class Charts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.charts';
    protected static ?string $navigationLabel = "Gráficos";

    protected ?string $heading = "Gráficos";

    protected function getFooterWidgets(): array
    {
        return [
            VisitWeekChart::class,
            VisitMonthChart::class,
            VisitYearByMonthChart::class
        ];
    }
}
