<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Lookup &mdash; CPUT Help</title>
    <style>
        body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:#F7F5F1;padding:30px;color:#1F2430;}
        .wrap{max-width:800px;margin:0 auto;}
        h1{font-size:22px;}
        .search-box{display:flex;gap:8px;margin-bottom:24px;}
        .search-box input{flex:1;padding:10px 14px;border:1px solid #DEDAD0;border-radius:8px;font-size:14px;}
        .search-box button{padding:10px 20px;border:none;background:#0072CE;color:#fff;border-radius:8px;font-weight:700;cursor:pointer;}
        .row{background:#fff;border:1px solid #DEDAD0;border-radius:10px;padding:14px 16px;margin-bottom:10px;}
        .row-title{font-weight:600;font-size:14.5px;}
        .row-meta{font-size:12.5px;color:#8B93A1;margin-top:4px;}
        .status-pill{font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px;text-transform:uppercase;}
        .status-completed{background:#E5F3EC;color:#2F855A;}
        .status-started{background:#FBEEDC;color:#B45309;}
        .empty{color:#8B93A1;font-size:14px;}
    </style>
</head>
<body>
<div class="wrap">
    <h1>Student video lookup</h1>
    <p style="color:#5B6472;font-size:13.5px;">Type in a student number to see which guides and videos they've watched.</p>

    <form method="GET" class="search-box">
        <input type="text" name="student_number" value="{{ $studentNumber }}" placeholder="e.g. 216217717" autofocus>
        <button type="submit">Search</button>
    </form>

    @if($studentNumber !== '')
        @forelse($results as $item)
            <div class="row">
                <div class="row-title">{{ $item->guide->title ?? 'Unknown guide' }}</div>
                <div class="row-meta">
                    <span class="status-pill status-{{ $item->status }}">{{ $item->status }}</span>
                    &middot; {{ $item->percent_watched }}% watched
                    &middot; last watched {{ $item->last_watched_at?->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="empty">No video activity found for student number "{{ $studentNumber }}".</p>
        @endforelse
    @endif
</div>
</body>
</html>
