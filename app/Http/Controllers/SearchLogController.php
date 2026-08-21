<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchLogStoreRequest;
use App\Models\SearchLog;
use Illuminate\Http\RedirectResponse;

class SearchLogController extends Controller
{
    public function store(SearchLogStoreRequest $request): RedirectResponse
    {
        SearchLog::create($request->validated());

        return back();
    }
}
