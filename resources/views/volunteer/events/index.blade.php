@extends('layouts.volunteer')
@section('title', 'Cari Kegiatan — AksiKita')

@push('styles')
<style>
.events-page-head {
    padding: 2rem 0 1rem;
    margin-bottom: 1rem;
}
.events-page-head h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #0F2057;
    letter-spacing: -0.02em;
    line-height: 1.25;
}
.events-page-head p {
    font-size: 14px;
    color: #5A6278;
    margin-top: 6px;
}

.search-form-container {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
}
.search-input-box {
    border: 1px solid #9099B0;
    border-radius: 999px;
    padding: 10px 20px;
    font-family: 'Plus Jakarta Sans', inherit;
    font-size: 14px;
    color: #1A1F2E;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
}
.search-input-box:focus { border-color: #0F2057; }
.search-input-box::placeholder { color: #9099B0; }

.input-keyword { flex: 3; min-width: 250px; }
.input-city { flex: 1.5; min-width: 150px; }
.input-category { flex: 1.5; min-width: 150px; cursor: pointer; appearance: auto; }

.search-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}
.btn-search {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 10px 24px;
    background: #1A3575; 
    color: #fff;
    border-radius: 999px;
    font-size: 14px; font-weight: 600;
    border: none; cursor: pointer;
    transition: background 0.15s;
}
.btn-search:hover { background: #0F2057; }
.btn-clear {
    display: inline-flex; align-items: center;
    padding: 10px 24px;
    background: transparent;
    color: #1A3575;
    border: 1px solid #1A3575;
    border-radius: 999px;
    font-size: 14px; font-weight: 600;
    text-decoration: none;
    transition: all 0.15s;
}
.btn-clear:hover { background: #EEF3FF; }

.results-meta {
    font-size: 14px; 
    font-weight: 600;
    color: #1A3575;
    margin-bottom: 1.5rem;
}

.events-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.ecard {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    display: flex; flex-direction: column;
    box-shadow: 0 2px 4px rgba(15,32,87,0.04);
}
.ecard-img {
    height: 160px;
    position: relative; 
    display: flex; align-items: flex-end; padding: 12px;
}
.ecard-cats { 
    display: flex; gap: 6px; flex-wrap: wrap; 
}
.ecard-cat {
    font-size: 10px; font-weight: 700;
    padding: 4px 12px; border-radius: 999px;
    background: #fff; color: #1A3575;
    border: 1px solid #1A3575;
    text-transform: uppercase; letter-spacing: 0.5px;
}
.ecard-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
.ecard-org {
    font-size: 11px; font-weight: 600; color: #5A6278; 
    text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;
}
.ecard-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 16px; font-weight: 700; color: #1A3575;
    line-height: 1.4; margin-bottom: 12px; flex: 1;
}
.ecard-meta { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
.ecard-meta-row {
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; color: #5A6278; font-weight: 500;
}
.ecard-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 14px; border-top: 1px solid #EEF0F6;
}
.ecard-slots { font-size: 13px; font-weight: 600; color: #5A6278; display: flex; align-items: center; gap: 6px; }
.ecard-btn {
    padding: 8px 24px; background: #1A3575; color: #fff; 
    border-radius: 999px; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: all 0.15s;
}
.ecard-btn:hover { background: #0F2057; }

@media (max-width: 900px) {
    .events-grid-3 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .search-form-container { flex-direction: column; align-items: stretch; }
    .input-keyword, .input-city, .input-category { width: 100%; flex: none; }
    .search-actions { width: 100%; display: grid; grid-template-columns: 1fr 1fr; }
    .btn-search, .btn-clear { justify-content: center; }
    .events-grid-3 { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="ak-container" style="padding-bottom: 3rem;">

    <div class="events-page-head">
        <h1>Cari Kegiatan</h1>
        <p>Temukan kegiatan sesuai minat kamu nyak</p>
    </div>

    <form method="GET" action="{{ route('volunteer.events') }}" id="eventsFilterForm">
        <div class="search-form-container">
            
            <input type="text"
                   class="search-input-box input-keyword"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Masukkan Kata Kunci.....">

            <input type="text"
                   class="search-input-box input-city"
                   name="city"
                   value="{{ request('city') }}"
                   placeholder="Kota...">

            <select class="search-input-box input-category" name="category">
                <option value="">Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}"
                            {{ request('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <div class="search-actions">
                <button type="submit" class="btn-search">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
                <a href="{{ route('volunteer.events') }}" class="btn-clear">Clear</a>
            </div>

        </div>
    </form>

    <div class="results-meta">
        {{ $events->total() }} Opportunities Found
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
        @endif

</div>
@endsection