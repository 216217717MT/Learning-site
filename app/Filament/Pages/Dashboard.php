<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Livewire\Attributes\Url;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static string $view = 'filament.pages.dashboard';

    // #[Url] means the chosen filter also shows in the web address,
    // so refreshing the page or sharing the link keeps your choice.
    #[Url]
    public string $dateRange = 'all';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\GuidePortalStatsOverview::class,
            \App\Filament\Widgets\MostViewedGuides::class,
            \App\Filament\Widgets\NeedsReviewGuides::class,
            \App\Filament\Widgets\SearchGapsWidget::class,
        ];
    }

    public function getWidgetsColumns(): int|array
    {
        return 2;
    }

    // Runs whenever the dropdown changes -- tells every widget on the
    // page to refresh itself using the new date range.
    public function updatedDateRange(): void
    {
        $this->dispatch('date-range-updated', range: $this->dateRange);
    }

    // Turns the dropdown's value into actual start/end dates every
    // widget can use in its database queries.
    public static function rangeToDates(string $range): array
    {
        return match ($range) {
            'week' => [now()->startOfWeek(), now()->endOfWeek()],
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            'year' => [now()->startOfYear(), now()->endOfYear()],
            default => [null, null], // 'all' -- no date limit
        };
    }
}

































//
//namespace App\Filament\Pages;
//
//use Filament\Pages\Page;
//
//class Dashboard extends Page
//{
//    protected static ?string $navigationIcon = 'heroicon-o-document-text';
//
//    protected static string $view = 'filament.pages.dashboard';
//}
