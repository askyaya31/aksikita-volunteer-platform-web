@extends('layouts.volunteer')
@section('title', 'Kegiatan Disukai')

@push('styles')
<style>
.liked-page-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    max-width: 900px; 
    margin: 0 auto; 
    padding: 2rem 1.5rem;
}
.liked-title {
    font-size: 22px; 
    font-weight: 700; 
    color: #0F2057; 
    margin-bottom: 1.5rem;
    letter-spacing: -0.01em;
}
.liked-empty {
    color: #9099B0; 
    font-size: 14px;
}
.liked-list {
    display: flex; 
    flex-direction: column; 
    gap: 12px;
}
</style>
@endpush

@section('content')
<div class="liked-page-wrap">
    <h1 class="liked-title">Kegiatan Disukai</h1>

    @if($likedEvents->isEmpty())
        <p class="liked-empty">Belum ada kegiatan yang kamu sukai.</p>
    @else
        <div class="liked-list">
            @foreach($likedEvents as $item)
                @if($item->event)
                    @include('components.event-list-item', ['event' => $item->event])
                @endif
            @endforeach
        </div>

        <div style="margin-top:1.5rem;">
            {{ $likedEvents->links() }}
        </div>
    @endif
</div>
@endsection