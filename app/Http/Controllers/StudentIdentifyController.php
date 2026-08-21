<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentIdentifyController extends Controller
{
    // Shows the "enter your student number" page.
    public function show(Request $request): View
    {
        // Remembers which guide the student was actually trying to reach,
        // so we can send them there right after they type their number.
        $intended = $request->query('redirect', route('guides.index'));

        return view('identify', ['redirect' => $intended]);
    }

    // Saves the number into their browser session (remembered only for
    // this visit -- not a real login, just self-reported identification).
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_number' => ['required', 'string', 'max:50'],
        ]);

        $request->session()->put('student_number', $request->input('student_number'));

        return redirect($request->input('redirect', route('guides.index')));
    }
}
