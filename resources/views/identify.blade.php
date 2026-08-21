@extends('layouts.app')

@section('content')
    <div class="hero">
        <h1>Before you continue</h1>
        <p>Please enter your student number so the Service Desk can see what you've watched if you call in.</p>
    </div>

    <div style="max-width:380px;margin:0 auto;">
        <form method="POST" action="{{ route('identify.store') }}">
            @csrf
            <input type="hidden" name="redirect" value="{{ $redirect }}">

            <div class="field" style="margin-bottom:14px;">
                <input
                    type="text"
                    name="student_number"
                    placeholder="e.g. 220012345"
                    required
                    style="width:100%;border:1px solid var(--border);border-radius:8px;padding:12px 14px;font-size:14px;"
                >
                @error('student_number')
                <p style="color:var(--amber);font-size:12.5px;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="doc-btn" style="width:100%;justify-content:center;border:none;cursor:pointer;">
                Continue
            </button>
        </form>
    </div>
@endsection
