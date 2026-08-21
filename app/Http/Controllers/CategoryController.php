<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // $category is resolved automatically via {category:slug} route binding.
    public function show(Request $request, Category $category): View
    {
        $guides = $category->guides()
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->get();

        return view('category.show', [
            'category' => $category,
            'guides' => $guides,
        ]);
    }
}
