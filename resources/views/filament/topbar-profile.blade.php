
<div x-data="{ open: false }" style="position:relative;">
    <button
        @click="open = !open"
        @click.outside="open = false"
        type="button"
        style="display:flex;align-items:center;gap:10px;padding:0 8px;background:transparent;border:none;cursor:pointer;"
    >
        <img
            src="{{ asset('images/profile.jpeg') }}"
            alt="{{ auth()->user()->name }}"
            style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #E6F1FB;"
        >
        <div style="text-align:left;line-height:1.2;">
            <div style="font-size:13px;font-weight:600;color:#1F2430;">{{ auth()->user()->name }}</div>
            <div style="font-size:11px;color:#8B93A1;"> Head Admin</div>
        </div>
        <svg style="width:16px;height:16px;color:#8B93A1;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M19 9l-7 7-7-7" />
        </svg>
    </button>

     {{--The actual dropdown menu -- hidden until the button above is clicked--}}
    <div
        x-show="open"
        x-cloak
        style="position:absolute;right:0;top:calc(100% + 8px);background:#fff;border:1px solid #DEDAD0;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:180px;padding:8px;z-index:50;"
    >
        <div style="padding:8px 10px;font-size:12px;color:#8B93A1;border-bottom:1px solid #DEDAD0;margin-bottom:6px;">
            Signed in as<br>
            <strong style="color:#1F2430;">{{ auth()->user()->email }}</strong>
        </div>

        <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
            @csrf
            <button
                type="submit"
                style="width:100%;text-align:left;padding:8px 10px;font-size:13px;color:#B42318;background:transparent;border:none;border-radius:6px;cursor:pointer;"
                onmouseover="this.style.background='#FBEAE8'"
                onmouseout="this.style.background='transparent'"
            >
                Sign out
            </button>
        </form>
    </div>
</div>















{{--<div style="display:flex;align-items:center;gap:10px;padding:0 8px;">--}}
{{--    <img--}}
{{--        src="{{ asset('images/profile.jpeg') }}"--}}
{{--        alt="{{ auth()->user()->name }}"--}}
{{--        style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #E6F1FB;"--}}
{{--    >--}}
{{--    <div style="text-align:left;line-height:1.2;">--}}
{{--        <div style="font-size:13px;font-weight:600;color:#1F2430;">{{ auth()->user()->name }}</div>--}}
{{--        <div style="font-size:11px;color:#8B93A1;"> Head Admin</div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<svg style="width:16px;height:16px;color:#8B93A1;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">  }}error what what--}}
{{--    <path d="M19 9l-7 7-7-7" />--}}
{{--</svg>--}}


{{--<div style="text-align:left;line-height:1.2;">--}}
{{--    <div style="font-size:13px;font-weight:600;color:#1F2430;">{{ auth()->user()->name }}</div>--}}
{{--    <div style="font-size:11px;color:#8B93A1;"> Head Admin</div>--}}
{{--</div>--}}
{{--<svg style="width:16px;height:16px;color:#8B93A1;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">--}}
{{--    <path d="M19 9l-7 7-7-7" />--}}
{{--</svg>--}}























