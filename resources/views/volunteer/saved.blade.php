@extends('layouts.volunteer')
@section('title', 'Kegiatan Tersimpan — AksiKita')

@push('styles')
<style>
:root {
    --navy:       #1E3A8A;
    --blue:       #3B82F6;
    --blue-bg:    #EFF6FF;
    --surface:    #ffffff;
    --page-bg:    #F0F4FF;
    --ink-soft:   #475569;
    --ink-muted:  #94a3b8;
    --border:     #e2e8f0;
}

.saved-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem 3rem;
}

.saved-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 20px;
}

.saved-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--navy);
    letter-spacing: -0.01em;
}

.saved-count {
    font-size: 13px;
    color: var(--ink-muted);
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}

@media (max-width: 900px) {
    .events-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 560px) {
    .events-grid { grid-template-columns: 1fr; }
}

.event-card {
    background: var(--surface);
    border-radius: 14px;
    border: 1px solid var(--border);
    overflow: hidden;
    transition: transform 0.15s, box-shadow 0.15s;
    display: flex;
    flex-direction: column;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(30, 58, 138, 0.10);
}

.card-thumb {
    width: 100%;
    aspect-ratio: 16 / 9;
    object-fit: cover;
    display: block;
}

.card-thumb-placeholder {
    width: 100%;
    aspect-ratio: 16 / 9;
    background: var(--blue-bg);
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-body {
    padding: 14px 14px 12px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-tags {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

.tag {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 99px;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.tag-lingkungan { background: #DCFCE7; color: #166534; }
.tag-sosial     { background: var(--blue-bg); color: #1E40AF; }
.tag-pendidikan { background: #FEF9C3; color: #854D0E; }
.tag-teknologi  { background: #F3E8FF; color: #6B21A8; }
.tag-kesehatan  { background: #FFE4E6; color: #9F1239; }
.tag-budaya     { background: #FFF7ED; color: #9A3412; }
.tag-default    { background: #F1F5F9; color: #475569; }

.card-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.4;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-org {
    font-size: 11.5px;
    color: var(--ink-muted);
    margin-bottom: 10px;
}

.card-meta {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: var(--ink-soft);
}

.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid var(--border);
    margin-top: auto;
}

.quota-pill {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: var(--ink-soft);
    background: var(--page-bg);
    border-radius: 99px;
    padding: 3px 10px;
}

.btn-lihat {
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    background: var(--navy);
    border: none;
    border-radius: 8px;
    padding: 6px 14px;
    cursor: pointer;
    transition: background 0.12s;
    text-decoration: none;
}

.btn-lihat:hover { background: var(--blue); color: #fff; }

.empty-state {
    text-align: center;
    padding: 5rem 1rem;
}

.empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--blue-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 14px;
}

.empty-state p {
    font-size: 14px;
    color: var(--ink-muted);
    line-height: 1.65;
}

.pagination-wrap {
    display: flex;
    justify-content: center;
    margin-top: 32px;
}
</style>
@endpush

@section('content')
<div class="saved-wrap">

    <div class="saved-header">
        <h1 class="saved-title">Kegiatan Tersimpan</h1>
        <span class="saved-count">{{ $saved->count() }} kegiatan</span>
    </div>

    @if($saved->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                     stroke="#3B82F6" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
            </div>
            <p>Belum ada kegiatan yang kamu simpan.</p>
        </div>
    @else
        <div class="events-grid">
            @foreach($saved as $item)
                @if($item->event)
                    @include('components.event-card-item', ['event' => $item->event])
                @endif
            @endforeach
        </div>

    @endif

</div>
@endsection