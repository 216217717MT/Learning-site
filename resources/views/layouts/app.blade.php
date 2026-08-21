<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">                {{--added--}}
    <title>@yield('title', 'CPUT Help') &mdash; Self-Service Portal</title>
    <style>
        :root{
            --ink:#1F2430; --ink-soft:#5B6472; --ink-faint:#8B93A1;
            --paper:#F7F5F1; --card:#FFFFFF;
            --maroon:#0072CE; --maroon-dark:#004C97; --maroon-tint:#E6F1FB;
            --slate:#2C3E50;
            --mint:#2F855A; --amber:#B45309;
            --border:#DEDAD0; --radius:10px;
            --shadow:0 1px 2px rgba(31,36,48,0.06), 0 6px 16px rgba(31,36,48,0.05);
        }
        *{box-sizing:border-box;}
        html, body{margin:0;width:100%;}
        body{
            background-image: url('{{ asset("images/background.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color:var(--ink);
            font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
            line-height:1.5;min-height:100vh;display:flex;flex-direction:column;
        }
        a{color:inherit;text-decoration:none;}

        .topbar{width:100%;background:var(--maroon);color:#fff;}
        .topbar-inner{width:100%;display:flex;align-items:center;justify-content:space-between;padding:14px 24px;}
        .brand{display:flex;align-items:center;gap:10px;font-weight:700;font-size:16px;}
        .brand-mark{width:30px;height:30px;border-radius:7px;background:rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;border:1px solid rgba(255,255,255,0.35);}
        .brand-logo{height:32px;width:auto;background:#fff;padding:4px;border-radius:7px;}

        main{flex:1;width:100%;max-width:1200px;margin:0 auto;padding:0 20px 60px;}

        /*footer{width:100%;padding:20px;text-align:center;font-size:11.5px;color:var(--ink-faint);}*/
        footer{width:100%;padding:20px;text-align:center;font-size:11.5px;color:var(--ink);}
        footer span{display:inline-block;background:rgba(255,255,255,0.85);padding:4px 14px;border-radius:6px;}

        .hero{padding:36px 0 22px;text-align:center;}
        .hero h1{font-size:24px;margin:0 0 6px;}
        .hero p{color:var(--ink-soft);margin:0 0 20px;font-size:14px;
            display:inline-block;background:rgba(255,255,255,0.85);padding:4px 14px;border-radius:6px;}
        .search-wrap{display:flex;align-items:center;gap:10px;max-width:520px;margin:0 auto;background:var(--card);
            border:1px solid var(--border);border-radius:999px;padding:0 6px 0 18px;height:46px;box-shadow:var(--shadow);}
        .search-wrap input{border:none;outline:none;flex:1;height:100%;font-size:14px;background:transparent;color:var(--ink);}
        .search-wrap button{border:none;background:var(--maroon);color:#fff;border-radius:999px;height:34px;padding:0 16px;font-size:13px;font-weight:700;cursor:pointer;}

        .section-label{font-size:11px;text-transform:uppercase;letter-spacing:0.08em;color:var(--ink);font-weight:700;margin:0 0 12px;
            display:inline-block;background:rgba(255,255,255,0.85);padding:4px 12px;border-radius:6px;}

        .cat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;margin-bottom:34px;}
        .cat-tile{background:var(--card);border:1px solid var(--border);border-radius:var(--radius);padding:16px 14px;
            display:flex;flex-direction:column;gap:8px;box-shadow:var(--shadow);}
        .cat-tile:hover{border-color:var(--maroon);}
        .cat-icon{width:32px;height:32px;border-radius:8px;background:var(--maroon-tint);color:var(--maroon-dark);
            display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;}
        .cat-icon-img{width:40px;height:40px;border-radius:8px;object-fit:cover;}
        .cat-name{font-size:13.5px;font-weight:600;}
        .cat-count{font-size:12px;color:var(--ink-faint);}

        .guide-card{display:flex;align-items:stretch;background:var(--card);border:1px solid var(--border);
            border-radius:var(--radius);overflow:hidden;margin-bottom:10px;box-shadow:0 4px 14px rgba(0,0,0,0.12);}
        .guide-strip{width:6px;background:var(--maroon);flex-shrink:0;}
        .guide-body{flex:1;display:flex;align-items:center;justify-content:space-between;padding:14px 16px;gap:10px;}
        .guide-main{display:flex;flex-direction:column;gap:4px;min-width:0;}
        .guide-tag{font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:10.5px;color:var(--maroon-dark);font-weight:600;}
        .guide-title{font-size:14.5px;font-weight:600;}
        .guide-meta{font-size:12px;color:var(--ink-faint);}
        .empty-note{color:var(--ink-faint);font-size:13.5px;padding:18px 0;}

        .crumb{display:flex;align-items:center;gap:6px;font-size:12.5px;color:var(--ink-soft);margin:22px 0 16px;}
        .crumb a{color:var(--maroon-dark);font-weight:600;}

        .article-head h1{font-size:21px;margin:0 0 6px;}
        .article-sub{color:var(--ink-soft);font-size:13.5px;margin:0 0 18px;}
        .video-box{background:var(--slate);color:#fff;border-radius:var(--radius);padding:16px;margin-bottom:16px;}
        .video-box a{color:#fff;text-decoration:underline;font-size:13.5px;}
        .video-embed{position:relative;width:100%;aspect-ratio:16/9;border-radius:var(--radius);overflow:hidden;margin-bottom:16px;background:var(--slate);}
        .video-embed iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:none;}

        .steps{margin-bottom:8px;}
        .step{display:flex;gap:12px;padding:12px 0;border-top:1px solid var(--border);}
        .step:first-child{border-top:none;}
        .step-num{width:24px;height:24px;border-radius:50%;background:var(--maroon-tint);color:var(--maroon-dark);
            font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;}
        .step-text{font-size:14.5px;padding-top:2px;}

        .feedback-box{margin-top:26px;padding:16px;background:var(--card);border:1px solid var(--border);border-radius:var(--radius);}
        .feedback-q{font-size:13px;color:var(--ink-soft);margin:0 0 10px;}
        .feedback-btns{display:flex;gap:8px;}
        .fbtn{border:1px solid var(--border);background:var(--card);border-radius:999px;padding:8px 16px;
            font-size:13px;font-weight:600;cursor:pointer;}
        .doc-btn{
            display:inline-flex;align-items:center;gap:10px;
            background:var(--maroon);color:#fff;
            border-radius:10px;padding:14px 20px;
            font-size:14.5px;font-weight:700;
            margin-bottom:16px;
            box-shadow:0 4px 14px rgba(0,0,0,0.15);
        }
        .doc-btn:hover{background:var(--maroon-dark);}
        .fbtn:hover{border-color:var(--maroon);}
        .feedback-thanks{font-size:13px;font-weight:600;margin-top:10px;}
        .feedback-thanks.ok{color:var(--mint);}
        .feedback-thanks.warn{color:var(--amber);}
    </style>
</head>
<body>
{{--<div class="topbar">--}}
{{--    <div class="topbar-inner">--}}
{{--        <a href="{{ route('guides.index') }}" class="brand">--}}
{{--            <img src="{{ asset('images/cput-logo.png') }}" alt="CPUT" class="brand-logo">--}}
{{--            CPUT Help--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</div>--}}

<main>
    @yield('content')
</main>
{{--<footer>CPUT Service Desk &mdash; self-service training portal</footer>--}}
{{--<footer>CPUT Service Desk &mdash; self-service training portal</footer>--}}
{{--<footer><span>CPUT Service Desk &mdash; self-service training portal</span></footer>--}}
<footer><span>CPUT Service Desk &mdash; self-service training portal</span></footer>
@stack('scripts')
</body>
</html>
