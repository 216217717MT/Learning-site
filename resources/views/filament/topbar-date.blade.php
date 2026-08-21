
<div style="position:absolute;left:50%;transform:translateX(-50%);">
    {{-- The real, working calendar -- invisible, but sitting exactly on
         top of the visible box below, so clicking anywhere on the
         visible design actually opens it. --}}
    <input
        type="date"
        id="topbar-date-picker"
        value="{{ now()->format('Y-m-d') }}"
        style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;"
        onchange="document.getElementById('topbar-date-label').textContent = new Date(this.value + 'T00:00:00').toLocaleDateString('en-US', {month:'long', day:'numeric', year:'numeric'});"
    >

    {{-- The visible design -- matches the reference picture exactly --}}
    <div style="display:flex;align-items:center;gap:6px;background:#F7F5F1;border:1px solid #DEDAD0;border-radius:8px;padding:6px 12px;font-size:13px;color:#1F2430;pointer-events:none;">
        <svg style="width:16px;height:16px;color:#8B93A1;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
        </svg>
        <span id="topbar-date-label">{{ now()->format('F j, Y') }}</span>
        <svg style="width:14px;height:14px;color:#8B93A1;margin-left:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>




{{--<div style="display:flex;align-items:center;gap:6px;background:#F7F5F1;border:1px solid #DEDAD0;border-radius:8px;padding:6px 12px;">--}}
{{--    <input--}}
{{--        type="date"--}}
{{--        value="{{ now()->format('Y-m-d') }}"--}}
{{--        style="border:none;background:transparent;font-size:13px;color:#1F2430;cursor:pointer;"--}}
{{--    >--}}
{{--</div>--}}




{{--<div style="display:flex;align-items:center;gap:6px;background:#F7F5F1;border:1px solid #DEDAD0;border-radius:8px;padding:6px 12px;font-size:13px;color:#1F2430;">--}}
{{--    <svg style="width:16px;height:16px;color:#8B93A1;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">--}}
{{--        <rect x="3" y="4" width="18" height="18" rx="2" />--}}
{{--        <path d="M16 2v4M8 2v4M3 10h18" />--}}
{{--    </svg>--}}
{{--    {{ now()->format('F j, Y') }}--}}
{{--    <svg style="width:14px;height:14px;color:#8B93A1;margin-left:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">--}}
{{--        <path d="M19 9l-7 7-7-7" />--}}
{{--    </svg>--}}
{{--</div>--}}
