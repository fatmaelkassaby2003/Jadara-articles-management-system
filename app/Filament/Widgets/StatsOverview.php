<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي المقالات', Article::count())
                ->description('جميع المقالات في النظام')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('المقالات المنشورة', Article::published()->count())
                ->description('المقالات المتاحة للزوار')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('التصنيفات', Category::count())
                ->description('إجمالي التصنيفات')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('warning'),

            Stat::make('المستخدمين', User::count())
                ->description('الكتاب والمسجلين')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
