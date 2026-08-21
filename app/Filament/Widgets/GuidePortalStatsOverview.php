<?php


namespace App\Filament\Widgets;

use App\Models\Guide;
use App\Models\GuideView;
use App\Models\GuideFeedback;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;

class GuidePortalStatsOverview extends BaseWidget
{
    // Works out the % change between two numbers, e.g. 120 vs 100 = "+20".
    // Returns null if there's nothing to meaningfully compare against.
    private function percentChange(int $current, int $previous): ?int
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : null;
        }

        return (int)round((($current - $previous) / $previous) * 100);
    }

    // Turns a percent change into the little description line Filament
    // shows under each number, e.g. "18% vs last week", with a
    // green up-arrow or red down-arrow automatically.
    private function trendDescription(?int $percent): array
    {
        if ($percent === null) {
            return ['description' => 'Not enough data yet', 'icon' => null, 'color' => 'gray'];
        }

        return [
            'description' => abs($percent) . '% vs last week',
            'icon' => $percent >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down',
            'color' => $percent >= 0 ? 'success' : 'danger',
        ];
    }

    protected function getStats(): array
    {
        $totalGuides = Guide::count();
        $publishedGuides = Guide::where('status', 'published')->count();
        $totalViews = Guide::sum('views_count');
        $totalHelpful = Guide::sum('helpful_count');
        $totalNotHelpful = Guide::sum('not_helpful_count');
        $totalResponses = $totalHelpful + $totalNotHelpful;

        $helpfulRate = $totalResponses > 0
            ? round(100 * $totalHelpful / $totalResponses)
            : null;

        $needsReviewCount = Guide::where('status', 'published')
            ->whereRaw('not_helpful_count > helpful_count')
            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
            ->count();

        // --- Real week-over-week comparisons ---

        $guidesThisWeek = Guide::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $guidesLastWeek = Guide::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $guidesTrend = $this->trendDescription($this->percentChange($guidesThisWeek, $guidesLastWeek));

        $viewsThisWeek = GuideView::whereBetween('viewed_at', [now()->startOfWeek(), now()])->count();
        $viewsLastWeek = GuideView::whereBetween('viewed_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $viewsTrend = $this->trendDescription($this->percentChange($viewsThisWeek, $viewsLastWeek));

        $helpfulThisWeek = GuideFeedback::where('is_helpful', true)->whereBetween('created_at', [now()->startOfWeek(), now()])->count();
        $helpfulLastWeek = GuideFeedback::where('is_helpful', true)->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
        $helpfulTrend = $this->trendDescription($this->percentChange($helpfulThisWeek, $helpfulLastWeek));

        // Small 7-day sparkline chart for views, using the trend package.
        $viewsChart = Trend::model(GuideView::class)
            ->dateColumn('viewed_at')
            ->between(start: now()->subDays(6), end: now())
            ->perDay()
            ->count()
            ->map(fn($item) => $item->aggregate)
            ->toArray();

        return [
            Stat::make('Total guides', $totalGuides)
                ->description($guidesTrend['description'])
                ->descriptionIcon($guidesTrend['icon'])
                ->descriptionColor($guidesTrend['color'])
                ->icon('heroicon-o-document-text')
                ->color('sa-blue'),

            Stat::make('Total views', number_format($totalViews))
                ->description($viewsTrend['description'])
                ->descriptionIcon($viewsTrend['icon'])
                ->descriptionColor($viewsTrend['color'])
                ->chart($viewsChart)
                ->icon('heroicon-o-eye')
                ->color('sa-green'),

            Stat::make('Helpful rate', $helpfulRate === null ? 'No data yet' : $helpfulRate . '%')
                ->description($helpfulTrend['description'])
                ->descriptionIcon($helpfulTrend['icon'])
                ->descriptionColor($helpfulTrend['color'])
                ->icon('heroicon-o-hand-thumb-up')
                ->color('sa-lightblue'),

            // Unchanged -- "needs review" is a live snapshot, not
            // something with real daily history to compare against.
            Stat::make('Needs review', $needsReviewCount)
                ->description($needsReviewCount > 0 ? 'Rated unhelpful more than helpful' : 'Nothing flagged')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('sa-navy'),
        ];
    }
}



//
//
//namespace App\Filament\Widgets;
//
//use App\Models\Guide;
//use Filament\Widgets\StatsOverviewWidget as BaseWidget;   Nornarl code
//use Filament\Widgets\StatsOverviewWidget\Stat;
//
//class GuidePortalStatsOverview extends BaseWidget
//{
//    protected function getStats(): array
//    {
//        $totalGuides = Guide::count();
//        $publishedGuides = Guide::where('status', 'published')->count();
//        $totalViews = Guide::sum('views_count');
//        $totalHelpful = Guide::sum('helpful_count');
//        $totalNotHelpful = Guide::sum('not_helpful_count');
//        $totalResponses = $totalHelpful + $totalNotHelpful;
//
//        $helpfulRate = $totalResponses > 0
//            ? round(100 * $totalHelpful / $totalResponses)
//            : null;
//
//        $needsReviewCount = Guide::where('status', 'published')
//            ->whereRaw('not_helpful_count > helpful_count')
//            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
//            ->count();
//
//        return [
//            Stat::make('Total guides', $totalGuides)
//                ->description($publishedGuides . ' published, ' . ($totalGuides - $publishedGuides) . ' draft/archived')
//                ->icon('heroicon-o-document-text')
//                ->color('sa-blue'),
//
//            Stat::make('Total views', number_format($totalViews))
//                ->description('Across all guides')
//                ->icon('heroicon-o-eye')
//                ->color('sa-green'),
//
//            Stat::make('Helpful rate', $helpfulRate === null ? 'No data yet' : $helpfulRate . '%')
//                ->description($totalResponses . ' responses total')
//                ->icon('heroicon-o-hand-thumb-up')
//                ->color('sa-gold'),
//
//            Stat::make('Needs review', $needsReviewCount)
//                ->description($needsReviewCount > 0 ? 'Rated unhelpful more than helpful' : 'Nothing flagged')
//                ->icon('heroicon-o-exclamation-triangle')
//                ->color('sa-red'),
//        ];
//    }
//}
//
//








////
////
////namespace App\Filament\Widgets;
////
////use App\Models\Guide;
////use Filament\Widgets\Widget;
////
////class GuidePortalStatsOverview extends Widget
////{
////    //protected static string $view = 'filament.widgets.guide-portal-stats-overview';
////
////    // This MUST be "static" -- writing it as a regular property (like we
////    // did last time) means Filament silently ignores it and falls back
////    // to a default width, which is what caused the widget to squeeze
////    // into the same row as "Most viewed guides" and stretch to match
////    // its height.
////    protected int|string|array $columnSpan = 'full';
////
////    public function getStats(): array
////    {
////        $totalGuides = Guide::count();
////        $publishedGuides = Guide::where('status', 'published')->count();
////        $totalViews = Guide::sum('views_count');
////        $totalHelpful = Guide::sum('helpful_count');
////        $totalNotHelpful = Guide::sum('not_helpful_count');
////        $totalResponses = $totalHelpful + $totalNotHelpful;
////
////        $helpfulRate = $totalResponses > 0
////            ? round(100 * $totalHelpful / $totalResponses)
////            : null;
////
////        $needsReviewCount = Guide::where('status', 'published')
////            ->whereRaw('not_helpful_count > helpful_count')
////            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
////            ->count();
////
////        return [
////            'totalGuides' => $totalGuides,
////            'publishedGuides' => $publishedGuides,
////            'totalViews' => $totalViews,
////            'helpfulRate' => $helpfulRate,
////            'totalResponses' => $totalResponses,
////            'needsReviewCount' => $needsReviewCount,
////        ];
////    }
////}
//
//
//namespace App\Filament\Widgets;
//
//use App\Models\Guide;
//use Filament\Widgets\StatsOverviewWidget as BaseWidget;
//use Filament\Widgets\StatsOverviewWidget\Stat;                            // clean code
//
//class GuidePortalStatsOverview extends BaseWidget
//{
//    protected function getStats(): array
//    {
//        $totalGuides = Guide::count();
//        $publishedGuides = Guide::where('status', 'published')->count();
//        $totalViews = Guide::sum('views_count');
//        $totalHelpful = Guide::sum('helpful_count');
//        $totalNotHelpful = Guide::sum('not_helpful_count');
//        $totalResponses = $totalHelpful + $totalNotHelpful;
//
//        $helpfulRate = $totalResponses > 0
//            ? round(100 * $totalHelpful / $totalResponses)
//            : null;
//
//        $needsReviewCount = Guide::where('status', 'published')
//            ->whereRaw('not_helpful_count > helpful_count')
//            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
//            ->count();
//
//        return [
//            Stat::make('Total guides', $totalGuides)
//                ->description($publishedGuides . ' published, ' . ($totalGuides - $publishedGuides) . ' draft/archived')
//                ->icon('heroicon-o-document-text')
//                ->color('info'),
//
//            Stat::make('Total views', number_format($totalViews))
//                ->description('Across all guides')
//                ->icon('heroicon-o-eye')
//                ->color('success'),
//
//            Stat::make('Helpful rate', $helpfulRate === null ? 'No data yet' : $helpfulRate . '%')
//                ->description($totalResponses . ' responses total')
//                ->icon('heroicon-o-hand-thumb-up')
//                ->color($helpfulRate !== null && $helpfulRate < 60 ? 'warning' : 'success'),
//
//            Stat::make('Needs review', $needsReviewCount)
//                ->description($needsReviewCount > 0 ? 'Rated unhelpful more than helpful' : 'Nothing flagged')
//                ->icon('heroicon-o-exclamation-triangle')
//                ->color($needsReviewCount > 0 ? 'danger' : 'info'),
//        ];
//    }
//}






//namespace App\Filament\Widgets;
//
//use App\Models\Guide;
//use Filament\Widgets\Widget;
//
//class GuidePortalStatsOverview extends Widget
//{
//    // Points to a Blade file we build ourselves, instead of using
//    // Filament's built-in Stat card layout -- this is what lets us use
//    // our own pictures instead of the icon library.
//    protected static string $view = 'filament.widgets.guide-portal-stats-overview';
//
//    // Makes this widget take up the full width of the dashboard row.
//    //protected int|string|array $columnSpan = 'full';
//    protected int|string|array $columnSpan = 2;
//
//    // Does all the real work: counts guides, adds up views, works out
//    // the helpful percentage, and checks which guides need review.
//    public function getStats(): array
//    {
//        $totalGuides = Guide::count();
//        $publishedGuides = Guide::where('status', 'published')->count();
//        $totalViews = Guide::sum('views_count');
//        $totalHelpful = Guide::sum('helpful_count');
//        $totalNotHelpful = Guide::sum('not_helpful_count');
//        $totalResponses = $totalHelpful + $totalNotHelpful;
//
//        $helpfulRate = $totalResponses > 0
//            ? round(100 * $totalHelpful / $totalResponses)
//            : null;
//
//        $needsReviewCount = Guide::where('status', 'published')
//            ->whereRaw('not_helpful_count > helpful_count')
//            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
//            ->count();
//
//        return [
//            'totalGuides' => $totalGuides,
//            'publishedGuides' => $publishedGuides,
//            'totalViews' => $totalViews,
//            'helpfulRate' => $helpfulRate,
//            'totalResponses' => $totalResponses,
//            'needsReviewCount' => $needsReviewCount,
//        ];
//    }
//}



////
////namespace App\Filament\Widgets;
////
////use App\Models\Guide;
////use Filament\Widgets\Widget;
////
////class GuidePortalStatsOverview extends Widget
////{
////    // Points to a Blade file we build ourselves, instead of using
////    // Filament's built-in Stat card layout -- this is what lets us use
////    // our own pictures instead of the icon library.
////    protected static string $view = 'filament.widgets.guide-portal-stats-overview';
////
////    // Makes this widget take up the full width of the dashboard row,
////    // instead of sharing space with something else next to it.
////    protected int|string|array $columnSpan = 'full';
////
////    // Does all the real work: counts guides, adds up views, works out
////    // the helpful percentage, and checks which guides need review.
////    // The Blade file above just displays whatever this returns.
////    public function getStats(): array
////    {
////        $totalGuides = Guide::count();
////        $publishedGuides = Guide::where('status', 'published')->count();
////        $totalViews = Guide::sum('views_count');
////        $totalHelpful = Guide::sum('helpful_count');
////        $totalNotHelpful = Guide::sum('not_helpful_count');
////        $totalResponses = $totalHelpful + $totalNotHelpful;
////
////        // Avoids a division-by-zero error if no feedback has been
////        // left by any student yet.
////        $helpfulRate = $totalResponses > 0
////            ? round(100 * $totalHelpful / $totalResponses)
////            : null;
////
////        // A guide "needs review" if it's published, has been rated
////        // unhelpful more times than helpful, and has at least 3
////        // responses total (so a single unlucky vote doesn't flag it).
////        $needsReviewCount = Guide::where('status', 'published')
////            ->whereRaw('not_helpful_count > helpful_count')
////            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
////            ->count();
////
////        return [
////            'totalGuides' => $totalGuides,
////            'publishedGuides' => $publishedGuides,
////            'totalViews' => $totalViews,
////            'helpfulRate' => $helpfulRate,
////            'totalResponses' => $totalResponses,
////            'needsReviewCount' => $needsReviewCount,
////        ];
////    }
////}
//namespace App\Filament\Widgets;
//
//use App\Models\Guide;
//use Filament\Widgets\Widget;
//
//class GuidePortalStatsOverview extends Widget
//{
//    // Points to a Blade file we build ourselves, instead of using
//    // Filament's built-in Stat card layout -- this is what lets us use
//    // our own pictures instead of the icon library.
//    protected static string $view = 'filament.widgets.guide-portal-stats-overview';
//
//    protected int|string|array $columnSpan = 'full';
//
//    public function getStats(): array
//    {
//        $totalGuides = Guide::count();
//        $publishedGuides = Guide::where('status', 'published')->count();
//        $totalViews = Guide::sum('views_count');
//        $totalHelpful = Guide::sum('helpful_count');
//        $totalNotHelpful = Guide::sum('not_helpful_count');
//        $totalResponses = $totalHelpful + $totalNotHelpful;
//
//        $helpfulRate = $totalResponses > 0
//            ? round(100 * $totalHelpful / $totalResponses)
//            : null;
//
//        $needsReviewCount = Guide::where('status', 'published')
//            ->whereRaw('not_helpful_count > helpful_count')
//            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
//            ->count();
//
//        return [
//            'totalGuides' => $totalGuides,
//            'publishedGuides' => $publishedGuides,
//            'totalViews' => $totalViews,
//            'helpfulRate' => $helpfulRate,
//            'totalResponses' => $totalResponses,
//            'needsReviewCount' => $needsReviewCount,
//        ];
//    }
//}
//
//


//orginal code

//namespace App\Filament\Widgets;
//
//use App\Models\Guide;
//use Filament\Widgets\StatsOverviewWidget as BaseWidget;
//use Filament\Widgets\StatsOverviewWidget\Stat;
//
//class GuidePortalStatsOverview extends BaseWidget
//{
//    protected function getStats(): array
//    {
//        $totalGuides = Guide::count();
//        $publishedGuides = Guide::where('status', 'published')->count();
//        $totalViews = Guide::sum('views_count');
//        $totalHelpful = Guide::sum('helpful_count');
//        $totalNotHelpful = Guide::sum('not_helpful_count');
//        $totalResponses = $totalHelpful + $totalNotHelpful;
//
//        $helpfulRate = $totalResponses > 0
//            ? round(100 * $totalHelpful / $totalResponses)
//            : null;
//
//        $needsReviewCount = Guide::where('status', 'published')
//            ->whereRaw('not_helpful_count > helpful_count')
//            ->whereRaw('(helpful_count + not_helpful_count) >= 3')
//            ->count();
//
//
//        return [
//            Stat::make('Total guides', $totalGuides)
//                ->description($publishedGuides . ' published, ' . ($totalGuides - $publishedGuides) . ' draft/archived')
//                ->icon('heroicon-o-document-text')
//                ->color('info'),
//
//            Stat::make('Total views', number_format($totalViews))
//                ->description('Across all guides')
//                ->icon('heroicon-o-eye')
//                ->color('success'),
//
//            Stat::make('Helpful rate', $helpfulRate === null ? 'No data yet' : $helpfulRate . '%')
//                ->description($totalResponses . ' responses total')
//                ->icon('heroicon-o-hand-thumb-up')
//                ->color($helpfulRate !== null && $helpfulRate < 60 ? 'warning' : 'success'),
//
//            Stat::make('Needs review', $needsReviewCount)
//                ->description($needsReviewCount > 0 ? 'Rated unhelpful more than helpful' : 'Nothing flagged')
//                ->icon('heroicon-o-exclamation-triangle')
//                ->color($needsReviewCount > 0 ? 'danger' : 'success'),
//        ];
//
//    }
//}


//        return [
//            Stat::make('Total guides', $totalGuides)
//                ->description($publishedGuides . ' published, ' . ($totalGuides - $publishedGuides) . ' draft/archived')
//                ->icon('heroicon-o-document-text')
//                ->color('info'),
//            Stat::make('Total views', number_format($totalViews))
//                ->description('Across all guides')
//                ->icon('heroicon-o-eye')
//                ->color('success'),
//            Stat::make('Helpful rate', $helpfulRate === null ? 'No data yet' : $helpfulRate . '%')
//                ->description($totalResponses . ' responses total')
//                ->color($helpfulRate !== null && $helpfulRate < 60 ? 'warning' : 'success')
//                ->icon('heroicon-o-hand-thumb-up'),
//            Stat::make('Needs review', $needsReviewCount)
//                ->description($needsReviewCount > 0 ? 'Rated unhelpful more than helpful' : 'Nothing flagged')
//                ->color($needsReviewCount > 0 ? 'danger' : 'success')
//                ->icon('heroicon-o-exclamation-triangle'),
//        ];
