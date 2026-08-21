@extends('layouts.app')

@section('content')
    <div class="hero">
        <h1>How can we help?</h1>
        <p>Search or browse a category below</p>

        <form method="GET" action="{{ route('guides.index') }}" class="search-wrap">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="search guides"
            >
            <button type="submit">Search</button>
        </form>
    </div>

    @php
        // Matches each category to its real picture file name.
        // Left side = category code name in the database.
        // Right side = the actual file name in public/images/categories/
        $categoryImages = [
            'wifi' => 'wifi.png',
            'registration' => 'registration.png',
            'email' => 'email.jpg',
            'printing' => 'printing.jpg',
            'password' => 'password.jpg',
            'learning' => 'learning-platforms.jpg',
            'crims' => 'crisms.png',
        ];
    @endphp

    @if($search !== '')
        <p class="section-label">{{ $guides->count() }} result{{ $guides->count() === 1 ? '' : 's' }} for "{{ $search }}"</p>

        @forelse($guides as $guide)
            @include('partials.guide-card', ['guide' => $guide])
        @empty
            <p class="empty-note">No matching guides. Try a different word, or contact the Service Desk.</p>
        @endforelse

        <p style="margin-top:16px;">
            <a href="{{ route('guides.index') }}" style="color:var(--maroon-dark);font-weight:600;font-size:13px;">
                &larr; Back to browsing
            </a>
        </p>
    @else
        <p class="section-label">Browse by category</p>
        <div class="cat-grid">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="cat-tile">
                    @if(isset($categoryImages[$category->slug]))
                        <img
                            src="{{ asset('images/categories/' . $categoryImages[$category->slug]) }}"
                            alt="{{ $category->name }}"
                            class="cat-icon-img"
                        >
                    @else
                        <div class="cat-icon">{{ $category->icon }}</div>
                    @endif
                    <div class="cat-name">{{ $category->name }}</div>
                    <div class="cat-count">
                        {{ $category->guides_count }} guide{{ $category->guides_count === 1 ? '' : 's' }}
                    </div>
                </a>
            @endforeach
        </div>

        <p class="section-label">Popular guides</p>
        @forelse($popularGuides as $guide)
            @include('partials.guide-card', ['guide' => $guide])
        @empty
            <p class="empty-note">No guides yet.</p>
        @endforelse
    @endif
@endsection
