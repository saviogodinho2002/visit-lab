<?php

namespace App\Filament\Pages;





use App\Filament\Resources\VisitChartResource\Widgets\VisitMonthChart;
use App\Filament\Resources\VisitChartResource\Widgets\VisitWeekChart;
use App\Filament\Resources\VisitChartResource\Widgets\VisitYearByMonthChart;
use App\Filament\Resources\VisitorChartResource\Widgets\VisitorWeekChart;
use App\Models\Visitor;
use Filament\Pages\Page;

class Charts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.pages.charts';
    protected static ?string $navigationLabel = "Gráficos";

    protected ?string $heading = "Gráficos";



   // protected static ?string $title = "Gráficos";


    protected function getFooterWidgets(): array
    {
        return [
            VisitWeekChart::class,
            VisitMonthChart::class,
            VisitYearByMonthChart::class,
        ];
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return (auth()->user()->laboratory_id != null) && auth()->user()->hasRole(["professor","monitor"]) ;
    }

}
