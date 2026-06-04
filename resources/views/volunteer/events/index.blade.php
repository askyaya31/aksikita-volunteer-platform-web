@extends('layouts.volunteer')
@section('title', 'Cari Kegiatan — AksiKita')

@push('styles')
<style>
.events-page-head {
    padding: 2rem 0 1.75rem;
    border-bottom: 1px solid #EEF0F6;
    margin-bottom: 1.75rem;
}
.events-page-head h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.375rem;
    font-weight: 700;
    color: #0F2057;
    letter-spacing: -0.02em;
    line-height: 1.25;
}
.events-page-head p {
    font-size: 13.5px;
    color: #5A6278;
    margin-top: 4px;
}
.search-bar-wrap {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #D8DCE8;
    padding: 6px 8px;
    display: flex; align-items: stretch; gap: 0;
    box-shadow: 0 1px 3px rgba(15,32,87,0.06);
    margin-bottom: 1.25rem;
    overflow: hidden;
}
.search-field {
    display: flex; flex-direction: column;
    padding: 7px 14px; flex: 3;
    border-right: 1px solid #EEF0F6;
}
.search-field:last-of-type { border-right: none; }
.search-field label {
    font-size: 10px; font-weight: 700;
    color: #9099B0; text-transform: uppercase;
    letter-spacing: 0.6px; margin-bottom: 2px;
}
.search-field input,
.search-field select {
    border: none; outline: none;
    font-family: 'Plus Jakarta Sans', inherit;
    font-size: 13.5px; font-weight: 500;
    color: #1A1F2E; background: transparent; width: 100%;
}
.search-field input::placeholder { color: #9099B0; }
.search-field select { cursor: pointer; }
.search-field.sm { flex: 1.5; }
.search-actions {
    display: flex; align-items: center; gap: 6px;
    margin-left: 6px; flex-shrink: 0;
}
.search-submit {
    display: flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    background: #0F2057;
    color: #fff;
    border-radius: 10px;
    font-size: 13.5px; font-weight: 600;
    border: none; cursor: pointer;
    transition: background 0.15s;
    white-space: nowrap;
}
.search-submit:hover { background: #1A3575; }
.search-reset {
    display: flex; align-items: center;
    padding: 9px 14px;
    background: #F8F9FC;
    color: #5A6278;
    border-radius: 10px;
    font-size: 13px; font-weight: 500;
    text-decoration: none;
    border: 1px solid #D8DCE8;
    transition: all 0.15s; white-space: nowrap;
}
.search-reset:hover { background: #EEF0F6; color: #0F2057; }

.filter-chips {
    display: flex; align-items: center; gap: 8px;
    flex-wrap: wrap; margin-bottom: 1rem;
}
.filter-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: #EEF3FF;
    border: 1px solid #C7D4F5;
    color: #0F2057;
    font-size: 12.5px; font-weight: 600;
    padding: 4px 10px 4px 12px;
    border-radius: 999px;
}
.filter-chip-remove {
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #C7D4F5;
    color: #0F2057;
    text-decoration: none;
    font-size: 10px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s;
}
.filter-chip-remove:hover { background: #A4B9F0; }

.results-meta {
    font-size: 13px; color: #5A6278;
    margin-bottom: 1.25rem;
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.results-meta strong { color: #0F2057; }
.sort-select {
    font-family: inherit;
    font-size: 12.5px; font-weight: 500;
    color: #5A6278; background: #fff;
    border: 1px solid #D8DCE8;
    border-radius: 8px; padding: 5px 10px;
    cursor: pointer;
}

.events-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 0.5rem;
}

.ecard {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #EEF0F6;
    overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: 0 1px 3px rgba(15,32,87,0.06);
    transition: box-shadow 0.2s, transform 0.2s;
}
.ecard:hover {
    box-shadow: 0 8px 32px rgba(15,32,87,0.12);
    transform: translateY(-3px);
}
.ecard-img {
    height: 140px;
    position: relative; overflow: hidden;
    display: flex; align-items: flex-end; padding: 10px 12px;
    flex-shrink: 0;
}
.ecard-cats { display: flex; gap: 4px; flex-wrap: wrap; position: relative; z-index: 1; }
.ecard-cat {
    font-size: 10px; font-weight: 700;
    padding: 2px 9px; border-radius: 999px;
    background: rgba(255,255,255,0.2); color: #fff;
    backdrop-filter: blur(4px);
    text-transform: uppercase; letter-spacing: 0.5px;
}
.ecard-quota-badge {
    position: absolute; top: 10px; right: 10px;
    font-size: 10px; font-weight: 700;
    padding: 3px 9px; border-radius: 999px; color: #fff;
}
.ecard-quota-badge.full { background: #EF4444; }
.ecard-quota-badge.low  { background: #F59E0B; }
.ecard-body { padding: 14px 16px 16px; flex: 1; display: flex; flex-direction: column; }
.ecard-org {
    font-size: 11px; font-weight: 600; color: #E8501A;
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;
}
.ecard-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px; font-weight: 700; color: #0F2057;
    line-height: 1.35; margin-bottom: 10px; flex: 1;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ecard-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 12px; }
.ecard-meta-row {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: #5A6278;
}
.ecard-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 10px; border-top: 1px solid #EEF0F6;
}
.ecard-slots { font-size: 12px; font-weight: 600; color: #0E7B6C; display: flex; align-items: center; gap: 4px; }
.ecard-slots.full { color: #EF4444; }
.ecard-btn {
    padding: 5px 16px; background: #EEF3FF; color: #0F2057;
    border-radius: 999px; font-size: 12px; font-weight: 700;
    text-decoration: none; transition: all 0.15s;
}
.ecard-btn:hover { background: #0F2057; color: #fff; }

.events-empty {
    text-align: center; padding: 3rem 1.5rem;
    background: #F8F9FC;
    border: 1.5px dashed #D8DCE8;
    border-radius: 18px;
}
.events-empty-icon {
    width: 52px; height: 52px; background: #EEF3FF;
    border-radius: 14px; margin: 0 auto 14px;
    display: flex; align-items: center; justify-content: center;
}
.events-empty h3 { font-size: 15px; font-weight: 700; color: #0F2057; margin-bottom: 6px; }
.events-empty p  { font-size: 13.5px; color: #5A6278; margin-bottom: 20px; }
.btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; background: #0F2057; color: #fff;
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer; transition: background 0.15s;
}
.btn-primary:hover { background: #1A3575; color: #fff; }

.events-pagination { margin-top: 2rem; display: flex; justify-content: center; }

@media (max-width: 900px) {
    .events-grid-3 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .search-bar-wrap { flex-direction: column; gap: 0; }
    .search-field { border-right: none; border-bottom: 1px solid #EEF0F6; }
    .search-field:last-of-type { border-bottom: none; }
    .search-actions { flex-direction: row; }
    .events-grid-3 { grid-template-columns: 1fr; }
    .results-meta { flex-direction: column; align-items: flex-start; gap: 8px; }
}
</style>
@endpush

@section('content')
<div class="ak-container" style="padding-bottom: 3rem;">

    <div class="events-page-head">
        <h1>Cari Kegiatan Sukarela</h1>
        <p>Temukan kegiatan yang sesuai dengan minat, lokasi, dan jadwalmu.</p>
    </div>

    <form method="GET" action="{{ route('volunteer.events') }}" id="eventsFilterForm">
        <div class="search-bar-wrap">

            <div class="search-field">
                <label for="filter-search">Kata kunci</label>
                <input type="text"
                       id="filter-search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Nama kegiatan, organisasi…">
            </div>

            <div class="search-field sm">
                <label for="filter-city">Kota</label>
                <input type="text"
                       id="filter-city"
                       name="city"
                       value="{{ request('city') }}"
                       placeholder="Yogyakarta…">
            </div>

            <div class="search-field sm">
                <label for="filter-cat">Kategori</label>
                <select id="filter-cat" name="category">
                    <option value="">Semua</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}"
                                {{ request('category') == $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="search-actions">
                <button type="submit" class="search-submit">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
                @if(request()->hasAny(['search','city','category']))
                    <a href="{{ route('volunteer.events') }}" class="search-reset">Reset</a>
                @endif
            </div>

        </div>
    </form>

    @if(request()->hasAny(['search','city','category']))
        <div class="filter-chips">
            <span style="font-size:11.5px; font-weight:600; color:#9099B0; text-transform:uppercase; letter-spacing:0.5px;">Filter:</span>

            @if(request('search'))
                <span class="filter-chip">
                    "{{ request('search') }}"
                    <a href="{{ request()->fullUrlWithQuery(['search'=>null,'page'=>null]) }}"
                       class="filter-chip-remove" aria-label="Hapus">&#x2715;</a>
                </span>
            @endif

            @if(request('city'))
                <span class="filter-chip">
                    {{ request('city') }}
                    <a href="{{ request()->fullUrlWithQuery(['city'=>null,'page'=>null]) }}"
                       class="filter-chip-remove" aria-label="Hapus">&#x2715;</a>
                </span>
            @endif

            @if(request('category'))
                @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                @if($activeCat)
                    <span class="filter-chip">
                        {{ $activeCat->name }}
                        <a href="{{ request()->fullUrlWithQuery(['category'=>null,'page'=>null]) }}"
                           class="filter-chip-remove" aria-label="Hapus">&#x2715;</a>
                    </span>
                @endif
            @endif
        </div>
    @endif

    <div class="results-meta">
        <span>
            Menampilkan <strong>{{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }}</strong>
            dari <strong>{{ $events->total() }}</strong> kegiatan
        </span>
    </div>

    @if($events->count() > 0)
        <div class="events-grid-3">
            @foreach($events as $event)
                @include('components.event-card', ['event' => $event])
            @endforeach
        </div>

        <div class="events-pagination">
            {{ $events->withQueryString()->links() }}
        </div>
    @else
        <div class="events-empty">
            <div class="events-empty-icon">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#1A3575" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3>Tidak ada kegiatan ditemukan</h3>
            <p>Coba ubah kata kunci, kota, atau kategori untuk hasil yang lebih luas.</p>
            <a href="{{ route('volunteer.events') }}" class="btn-primary">Tampilkan semua kegiatan</a>
        </div>
    @endif

</div>
@endsection