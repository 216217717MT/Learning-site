<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\GuideFeedbackController;
use App\Http\Controllers\SearchLogController;
use App\Http\Controllers\StudentIdentifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuideController::class, 'index'])->name('guides.index');

Route::get('/identify', [StudentIdentifyController::class, 'show'])->name('identify.show');
Route::post('/identify', [StudentIdentifyController::class, 'store'])->name('identify.store');

// The student number is required before viewing an actual guide page.
Route::get('/guides/{guide:slug}', [GuideController::class, 'show'])
    ->middleware('student.identified')
    ->name('guides.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/guide-feedback', [GuideFeedbackController::class, 'store'])->name('guide-feedback.store');
Route::post('/search-log', [SearchLogController::class, 'store'])->name('search-log.store');
































//use App\Http\Controllers\CategoryController;
//use App\Http\Controllers\GuideController;
//use App\Http\Controllers\GuideFeedbackController;
//use App\Http\Controllers\SearchLogController;
//use Illuminate\Support\Facades\Route;
//
//Route::get('/', [GuideController::class, 'index'])->name('guides.index');
//Route::get('/guides/{guide:slug}', [GuideController::class, 'show'])->name('guides.show');
//Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
//Route::post('/guide-feedback', [GuideFeedbackController::class, 'store'])->name('guide-feedback.store');
//Route::post('/search-log', [SearchLogController::class, 'store'])->name('search-log.store');

Route::post('/video-progress', [App\Http\Controllers\VideoProgressController::class, 'store'])->name('video-progress.store');

Route::get('/staff/lookup', [App\Http\Controllers\StudentLookupController::class, 'show'])->name('staff.lookup');
