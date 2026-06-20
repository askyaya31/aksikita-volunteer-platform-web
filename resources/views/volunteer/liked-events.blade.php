@extends('layouts.volunteer')
@section('title', 'Kegiatan Disukai')

@push('styles')
<style>
:root {
    --navy:       #1E3A8A;
    --blue:       #3B82F6;
    --blue-light: #93C5FD;
    --blue-ghost: #BFDBFE;
    --blue-bg:    #EFF6FF;
    --surface:    #ffffff;
    --page-bg:    #F0F4FF;
    --ink:        #1e293b;
    --ink-soft:   #475569;
    --ink-muted:  #94a3b8;
    --border:     #e2e8f0;
}

.liked-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem 3rem;
}

.liked-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 20px;
}

.liked-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--navy);
    letter-spacing: -0.01em;
}

.liked-count {
    font-size: 13px;
    color: var(--ink-muted);
}

.filter-row {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.filter-chip {
    font-size: 12px;
    font-weight: 500;
    padding: 5px 14px;
    border-radius: 99px;
    border: 1.5px solid var(--border);
    background: var(--surface);
    color: var(--ink-soft);
    cursor: pointer;
    transition: all 0.12s;
    text-decoration: none;
}

.filter-chip.active,
.filter-chip:hover {
    border-color: var(--navy);
    color: var(--navy);
}

.filter-chip.active {
    background: var(--navy);
    color: #fff;
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

.card-actions {
    display: flex;
    align-items: center;
    gap: 6px;
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

.liked-badge {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--blue-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

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

@php
    $tagColors = [
        'lingkungan' => 'tag-lingkungan',
        'sosial'     => 'tag-sosial',
        'pendidikan' => 'tag-pendidikan',
        'teknologi'  => 'tag-teknologi',
        'kesehatan'  => 'tag-kesehatan',
        'budaya'     => 'tag-budaya',
    ];

    $categories = \App\Models\Category::orderBy('name')->get();
    $activeCategory = request('category');
@endphp

<div class="liked-wrap">

    <div class="liked-header">
        <h1 class="liked-title">Kegiatan Disukai</h1>
        <span class="liked-count">{{ $likedEvents->total() }} kegiatan</span>
    </div>

    <div class="filter-row">
        <a href="{{ route('volunteer.liked-events') }}"
           class="filter-chip {{ !$activeCategory ? 'active' : '' }}">Semua</a>
        @foreach($categories as $cat)
            <a href="{{ route('volunteer.liked-events', ['category' => $cat->slug]) }}"
               class="filter-chip {{ $activeCategory === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    @if($likedEvents->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                     stroke="#3B82F6" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5
                             4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <p>Belum ada kegiatan yang kamu sukai.<br>Jelajahi kegiatan dan tekan hati untuk menyimpannya.</p>
        </div>
    @else
        <div class="events-grid">
            @foreach($likedEvents as $item)
                @if($item->event)
                    @php
                        $event = $item->event;
                        $eventCategories = $event->categories ?? collect();
                        $thumb = $event->poster ?? null;
                        $orgName = $event->organization->organization_name ?? '-';
                        $quota = $event->quota ?? null;
                        $location = $event->location_name ?? $event->city ?? null;
                        $date = $event->start_date ?? null;
                    @endphp

                    <div class="event-card">
                        @if($thumb)
                            <img class="card-thumb"
                                 src="{{ Storage::url($thumb) }}"
                                 alt="{{ $event->title }}">
                        @else
                            <div class="card-thumb-placeholder">
                                <svg width="36" height="36" fill="none" viewBox="0 0 24 24"
                                     stroke="#93C5FD" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2
                                             l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01
                                             M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2
                                             0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="card-body">
                            @if($eventCategories->isNotEmpty())
                                <div class="card-tags">
                                    @foreach($eventCategories->take(3) as $cat)
                                        @php
                                            $slug = strtolower($cat->slug ?? $cat->name);
                                            $cls  = $tagColors[$slug] ?? 'tag-default';
                                        @endphp
                                        <span class="tag {{ $cls }}">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="card-title">{{ $event->title }}</div>
                            <div class="card-org">{{ $orgName }}</div>

                            <div class="card-meta">
                                @if($location)
                                    <div class="meta-item">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0
                                                     01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $location }}
                                    </div>
                                @endif
                                @if($date)
                                    <div class="meta-item">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        {{ $date->translatedFormat('d M Y') }}
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                @if($quota)
                                    <div class="quota-pill">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                             stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10
                                                     0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3
                                                     3 0 015.356-1.857M7 20v-2c0-.656.126-1.283
                                                     .356-1.857m0 0a5.002 5.002 0 019.288
                                                     0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $quota }} kuota
                                    </div>
                                @else
                                    <div></div>
                                @endif

                                <div class="card-actions">
                                    <div class="liked-badge" title="Disukai">
                                        <svg width="14" height="14" fill="#3B82F6" viewBox="0 0 24 24"
                                             stroke="#3B82F6" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5
                                                     4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                    <a href="{{ route('volunteer.events.show', $event) }}"
                                       class="btn-lihat">Lihat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $likedEvents->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection