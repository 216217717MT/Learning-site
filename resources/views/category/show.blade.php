@extends('layouts.app')

@section('content')
    <div class="crumb">
        <a href="{{ route('guides.index') }}">Home</a> <span>/</span>
        <span>{{ $category->name }}</span>
    </div>

    <p class="section-label">{{ $category->name }} guides</p>

    @forelse($guides as $guide)
        @include('partials.guide-card', ['guide' => $guide])
    @empty
        <p class="empty-note">No guides in this category yet.</p>
    @endforelse
@endsection
