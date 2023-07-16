<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard as BasePage;
class DashBoard extends BasePage
{
    protected function getColumns(): int | string | array
    {
        return 1;
    }
}
