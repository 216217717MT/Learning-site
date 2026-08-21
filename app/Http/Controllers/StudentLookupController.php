<?php

namespace App\Http\Controllers;

use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentLookupController extends Controller
{
        public function show(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        // Only logged-in staff (the same login used for /admin) can view this page.
        if (! auth()->check()) {
            return redirect('/admin/login');
        }

        $studentNumber = trim((string) $request->get('student_number', ''));
        $results = collect();

        if ($studentNumber !== '') {
            $results = VideoProgress::with(['guide', 'guideVideo'])
                ->where('student_number', $studentNumber)
                ->orderByDesc('last_watched_at')
                ->get();
        }

        return view('admin-lookup', [
            'studentNumber' => $studentNumber,
            'results' => $results,
        ]);
    }
}
