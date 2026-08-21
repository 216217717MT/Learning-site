<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentIdentified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('student_number')) {
            return redirect()->route('identify.show', ['redirect' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
