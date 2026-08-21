
<a href="{{ route('guides.show', $guide) }}" class="guide-card">
    <div class="guide-strip"></div>
    <div class="guide-body">
        <div class="guide-main">
            <span class="guide-tag">{{ $guide->tag }}</span>
<span class="guide-title">{{ $guide->title }}</span>
<span class="guide-meta">{{ $guide->summary }}</span>
</div>
</div>
</a>
