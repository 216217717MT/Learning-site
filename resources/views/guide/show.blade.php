@extends('layouts.app')

@section('content')
    <div class="crumb">
        <a href="{{ route('guides.index') }}">Home</a> <span>/</span>
        <a href="{{ route('categories.show', $guide->category) }}">{{ $guide->category->name }}</a> <span>/</span>
        <span>{{ $guide->title }}</span>
    </div>

    <div class="article-head">
        <h1>{{ $guide->title }}</h1>
        <p class="article-sub">{{ $guide->summary }}</p>
    </div>

    @if($guide->guideVideos->isNotEmpty())
        @foreach($guide->guideVideos as $video)
            @if($video->embed_url)
                <div class="video-embed">
                    <iframe
                        id="yt-player-{{ $video->id }}"
                        src="{{ $video->embed_url }}"
                        title="{{ $guide->title }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        data-guide-id="{{ $guide->id }}"
                        data-video-id="{{ $video->id }}"
                        data-provider="{{ $video->provider }}"
                    ></iframe>
                </div>
            @else
                {{-- Fallback for URLs we couldn't convert to an embed (e.g. a
                     direct file upload, or an unrecognized link format) --}}
                <div class="video-box">
                    <p style="margin:0;">
                        &#9654; <a href="{{ $video->video_url }}" target="_blank" rel="noopener">
                            Watch video ({{ ucfirst($video->provider) }})
                        </a>
                    </p>
                </div>
            @endif
        @endforeach
    @endif

    @if($guide->steps_document)
        <a href="{{ asset('storage/' . $guide->steps_document) }}" target="_blank" rel="noopener" class="doc-btn">
            &#128196; Open step-by-step document
        </a>
    @elseif($guide->guideSteps->isNotEmpty())
        {{-- No PDF -- fall back to the plain numbered list, like before. --}}
        <p class="section-label">Step-by-step</p>
        <div class="steps">
            @foreach($guide->guideSteps as $step)
                <div class="step">
                    <div class="step-num">{{ $step->step_number }}</div>
                    <div class="step-text">{{ $step->content }}</div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="feedback-box">
        @if(session('feedback_message'))
            <p class="feedback-thanks {{ session('feedback_was_helpful') ? 'ok' : 'warn' }}">
                {{ session('feedback_message') }}
            </p>
        @else
            <p class="feedback-q">Did this solve your issue?</p>
            <div class="feedback-btns">
                <form method="POST" action="{{ route('guide-feedback.store') }}">
                    @csrf
                    <input type="hidden" name="guide_id" value="{{ $guide->id }}">
                    <input type="hidden" name="is_helpful" value="1">
                    <button type="submit" class="fbtn">Yes, sorted</button>
                </form>
                <form method="POST" action="{{ route('guide-feedback.store') }}">
                    @csrf
                    <input type="hidden" name="guide_id" value="{{ $guide->id }}">
                    <input type="hidden" name="is_helpful" value="0">
                    <button type="submit" class="fbtn">Still stuck</button>
                </form>
            </div>
        @endif
    </div>

    @if($related->isNotEmpty())
        <p class="section-label" style="margin-top:26px;">Related guides</p>
        @foreach($related as $relatedGuide)
            @include('partials.guide-card', ['guide' => $relatedGuide])
        @endforeach
    @endif

    @push('scripts')
        <script>
            // Loads YouTube's own player-control code so we can "listen in" on
            // play/pause/finish -- this only runs for youtube videos on this page.
            var ytTag = document.createElement('script');
            ytTag.src = "https://www.youtube.com/iframe_api";
            document.head.appendChild(ytTag);

            var trackedPlayers = [];

            window.onYouTubeIframeAPIReady = function() {
                document.querySelectorAll('iframe[data-provider="youtube"]').forEach(function(iframe) {
                    var guideId = iframe.dataset.guideId;
                    var videoId = iframe.dataset.videoId;

                    var player = new YT.Player(iframe.id, {
                        events: {
                            onStateChange: function(event) {
                                handleStateChange(event, guideId, videoId, player);
                            }
                        }
                    });
                    trackedPlayers.push(player);
                });
            };

            var progressIntervals = {};

            function handleStateChange(event, guideId, videoId, player) {
                // 1 = playing, 0 = finished, 2 = paused
                if (event.data === 1) {
                    sendProgress(guideId, videoId, 'started', currentPercent(player));

                    // While playing, check progress every 5 seconds.
                    progressIntervals[videoId] = setInterval(function() {
                        sendProgress(guideId, videoId, 'started', currentPercent(player));
                    }, 5000);
                } else {
                    clearInterval(progressIntervals[videoId]);

                    if (event.data === 0) {
                        sendProgress(guideId, videoId, 'completed', 100);
                    }
                }
            }

            function currentPercent(player) {
                try {
                    var duration = player.getDuration();
                    var current = player.getCurrentTime();
                    if (!duration) return 0;
                    return Math.min(100, Math.round((current / duration) * 100));
                } catch (e) {
                    return 0;
                }
            }

            function sendProgress(guideId, videoId, status, percent) {
                fetch("{{ route('video-progress.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        guide_id: guideId,
                        guide_video_id: videoId,
                        status: status,
                        percent_watched: percent,
                    }),
                });
            }
        </script>
    @endpush
@endsection
