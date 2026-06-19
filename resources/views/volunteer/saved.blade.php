@extends('layouts.volunteer')
@section('title', 'Kegiatan Tersimpan — AksiKita')

@push('styles')
<style>
.saved-page-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif; 
    max-width: 900px; 
    margin: 0 auto; 
    padding: 2rem 1.5rem;
}
.saved-title {
    font-size: 22px; 
    font-weight: 700; 
    color: #0F2057; 
    margin-bottom: 1.5rem;
    letter-spacing: -0.01em;
}
.saved-empty {
    color: #9099B0; 
    font-size: 14px;
}
.saved-list {
    display: flex; 
    flex-direction: column; 
    gap: 12px;
}
</style>
@endpush

@section('content')
<div class="saved-page-wrap">
    <h1 class="saved-title">Kegiatan Tersimpan</h1>

    @if($saved->isEmpty())
        <p class="saved-empty">Belum ada kegiatan yang kamu simpan.</p>
    @else
        <div class="saved-list">
            @foreach($saved as $item)
                @if($item->event)
                    @include('components.event-list-item', ['event' => $item->event])
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection