<?php

namespace App\Filament\Pages;

use App\Filament\Resources\VisitCharResource\Widgets\VisitMonthChart;
use App\Filament\Resources\VisitCharResource\Widgets\VisitWeekChart;
use App\Filament\Resources\VisitCharResource\Widgets\VisitYearByMonthChart;
use App\Filament\Resources\VisitGeralChartResource\Widgets\MostVisitLaboratoryMonthChart;
use App\Filament\Resources\VisitGeralChartResource\Widgets\MostVisitLaboratoryWeekChart;
use Filament\Pages\Page;

class ChartGeral extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.chart-geral';

    protected static ?string $navigationLabel = "Gráficos Gerais";

    protected ?string $heading = "Gráficos Gerais";
    protected function getFooterWidgets(): array
    {
        return [
            MostVisitLaboratoryWeekChart::class,
            MostVisitLaboratoryMonthChart::class
        ];
    }
    protected static function shouldRegisterNavigation(): bool
    {
        return (auth()->user()->laboratory_id == null) && auth()->user()->hasRole(["admin"]) ;
    }
}
