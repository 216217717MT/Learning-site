<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuideController extends Controller
{
    // Handles the home page: search box, category tiles, and popular guides.
    public function index(Request $request): View
    {
        // Only ever show published guides to students -- drafts/archived
        // guides stay invisible on the public side regardless of search.
        $query = Guide::query()->where('status', 'published')->with('category');

        $search = trim((string) $request->get('q', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        $guides = $query->orderByDesc('views_count')->get();

        // If someone searched and got nothing back, log it -- this is
        // what feeds the admin dashboard's "content gaps" panel.
        if ($search !== '' && $guides->isEmpty()) {
            \App\Models\SearchLog::create([
                'query_text' => $search,
                'normalized_query' => strtolower($search),
                'result_count' => 0,
                'user_id' => auth()->id(),
            ]);
        }

        // Category tiles with a live count of published guides in each --
        // relies on Category::guides() existing as a hasMany relationship.
        $categories = Category::withCount(['guides' => function ($q) {
            $q->where('status', 'published');
        }])->orderBy('sort_order')->get();

        // "Popular guides" section: only shown when not actively searching,
        // ranked by views -- matches the HTML prototype's homepage.
        $popularGuides = Guide::where('status', 'published')
            ->orderByDesc('views_count')
            ->limit(3)
            ->get();

        return view('guide.index', [
            'guides' => $guides,
            'categories' => $categories,
            'popularGuides' => $popularGuides,
            'search' => $search,
        ]);
    }

    // Individual guide/article page. $guide is already resolved by Laravel
    // via the {guide:slug} route binding -- no manual lookup needed.
    public function show(Request $request, Guide $guide): View
    {
        $guide->increment('views_count');

        // Also record exactly when this view happened, so the dashboard's
        // date filter has real timestamps to work with (the views_count
        // number above never remembers *when*, only the total).
        $guide->guideViews()->create([
            'viewed_at' => now(),
        ]);

        $guide->load([
            'category',
            'guideSteps' => fn ($q) => $q->orderBy('step_number'),
            'guideVideos' => fn ($q) => $q->orderBy('sort_order'),
        ]);

        $related = Guide::where('category_id', $guide->category_id)
            ->where('id', '!=', $guide->id)
            ->where('status', 'published')
            ->limit(2)
            ->get();

        return view('guide.show', [
            'guide' => $guide,
            'related' => $related,
        ]);
    }
}
