@extends('layouts.volunteer')
@section('title', 'Riwayat Kegiatan — AksiKita')

@push('styles')
<style>
.history-wrap {
    max-width: 920px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 4.5rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.history-head {
    margin-bottom: 22px;
}
.history-head__title {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--color-text-primary);
    letter-spacing: -0.025em;
    line-height: 1.2;
}
.history-head__sub {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin-top: 4px;
}

.history-search-wrap {
    position: relative;
    margin-bottom: 18px;
}
.history-search-icon {
    position: absolute;
    left: 14px; top: 50%;
    transform: translateY(-50%);
    color: var(--color-text-muted);
    pointer-events: none;
}
.history-search {
    width: 100%;
    padding: 12px 40px 12px 40px;
    border-radius: 12px;
    border: 1.5px solid var(--color-border);
    background: var(--color-surface);
    font-size: 0.875rem;
    font-family: inherit;
    color: var(--color-text-primary);
    transition: border-color 0.15s, background 0.15s;
}
.history-search::placeholder { color: var(--color-text-muted); }
.history-search:focus {
    outline: none;
    border-color: #0F2057;
    background: #fff;
}
.history-search-clear {
    position: absolute;
    right: 10px; top: 50%;
    transform: translateY(-50%);
    width: 22px; height: 22px;
    border-radius: 50%;
    border: none;
    background: var(--color-border);
    color: var(--color-text-muted);
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    line-height: 1;
}
.history-search-clear.is-visible { display: flex; }

.history-tabs {
    display: flex;
    gap: 4px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    background: var(--color-surface);
    border-radius: 14px;
    padding: 5px;
    margin-bottom: 24px;
    border: 1.5px solid var(--color-border);
    box-shadow: 0 1px 2px rgba(15, 32, 87, 0.04);
}
.history-tabs::-webkit-scrollbar { display: none; }

.history-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    border-radius: 10px;
    font-size: 0.8125rem;
    font-weight: 700;
    white-space: nowrap;
    color: var(--color-text-muted);
    background: transparent;
    border: none;
    cursor: pointer;
    transition: all 0.18s;
    flex-shrink: 0;
}
.history-tab:hover:not(.history-tab--active) {
    color: var(--color-text-primary);
    background: rgba(15, 32, 87, 0.04);
}
.history-tab--active {
    background: #0F2057;
    color: #fff;
}
.history-tab__count {
    font-size: 0.6875rem;
    font-weight: 800;
    padding: 1px 7px;
    border-radius: 9999px;
    background: rgba(15, 32, 87, 0.08);
    color: var(--color-text-muted);
}
.history-tab--active .history-tab__count {
    background: rgba(255,255,255,0.22);
    color: #fff;
}

.history-result-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.8rem;
    color: var(--color-text-muted);
}
.history-result-row strong { color: var(--color-text-primary); font-weight: 700; }

.history-group-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--color-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin: 30px 0 12px;
}
.history-group-label:first-of-type { margin-top: 0; }
.history-group-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--color-border);
}

.history-card {
    background: var(--color-canvas);
    border: 1px solid var(--color-border);
    border-radius: 18px;
    padding: 16px 18px;
    margin-bottom: 10px;
    display: flex;
    gap: 16px;
    align-items: center;
    transition: box-shadow 0.18s, transform 0.18s, border-color 0.18s;
    text-decoration: none;
}
.history-card:hover {
    box-shadow: 0 8px 22px rgba(15, 32, 87, 0.08);
    transform: translateY(-1px);
    border-color: #DCE9FF;
}
.history-card.is-hidden { display: none; }

.history-card__thumb {
    width: 88px; height: 88px;
    border-radius: 14px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--color-surface);
    display: flex;
    align-items: center;
    justify-content: center;
}
.history-card__thumb img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.history-card__thumb-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}

.history-card__body { flex: 1; min-width: 0; }

.history-card__cats {
    display: flex; gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 7px;
}
.history-cat-pill {
    font-size: 0.6875rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 9999px;
    letter-spacing: 0.02em;
    background: var(--color-surface);
    color: var(--color-text-muted);
}

.history-card__title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--color-text-primary);
    letter-spacing: -0.012em;
    line-height: 1.35;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.history-card__org {
    font-size: 0.8125rem;
    color: var(--color-text-muted);
    margin-bottom: 9px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.history-card__meta {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 0.78rem;
    color: var(--color-text-muted);
    flex-wrap: wrap;
}
.history-card__meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

.history-card__right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 7px;
    flex-shrink: 0;
    align-self: center;
    min-width: 108px;
}

.history-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 18px;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.01em;
    line-height: 1;
    white-space: nowrap;
}
.history-badge--confirmed,
.history-badge--attended {
    background: #10B981;
    color: #fff;
}
.history-badge--pending {
    background: #FEF3C7;
    color: #92400E;
}
.history-badge--cancelled {
    background: #FEE2E2;
    color: #991B1B;
}

.history-card--confirmed,
.history-card--attended {
    border-left: 3px solid #10B981;
    padding-left: 16px;
}

.history-card__date {
    font-size: 0.74rem;
    color: var(--color-text-muted);
    font-weight: 500;
    white-space: nowrap;
}

.history-empty {
    text-align: center;
    padding: 64px 24px;
    background: var(--color-canvas);
    border: 1px dashed var(--color-border);
    border-radius: 18px;
}
.history-empty.is-hidden { display: none; }
.history-empty__icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    background: #EFF6FF;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
}
.history-empty h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-text-primary);
    margin-bottom: 6px;
}
.history-empty p {
    font-size: 0.875rem;
    color: var(--color-text-muted);
    margin-bottom: 20px;
}

.history-pagination {
    margin-top: 28px;
    display: flex;
    justify-content: center;
}

@media (max-width: 560px) {
    .history-card { flex-wrap: wrap; }
    .history-card__right { flex-direction: row; align-items: center; margin-left: auto; align-self: center; min-width: 0; }
    .history-card__thumb { width: 60px; height: 60px; border-radius: 12px; }
}
</style>
@endpush

@section('content')
<div class="history-wrap">

    <div class="history-head">
        <h1 class="history-head__title">Riwayat Kegiatan</h1>
        <p class="history-head__sub">Semua kegiatan yang pernah kamu daftarkan.</p>
    </div>

    <div class="history-search-wrap">
        <svg class="history-search-icon" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text"
               id="historySearch"
               class="history-search"
               placeholder="Cari kegiatan, organisasi, atau kota…"
               autocomplete="off">
        <button type="button" id="historySearchClear" class="history-search-clear" aria-label="Hapus pencarian">&times;</button>
    </div>

    <div class="history-tabs" id="historyTabs">
        <button type="button" class="history-tab history-tab--active" data-status="all">
            Semua <span class="history-tab__count" data-count="all">0</span>
        </button>
        <button type="button" class="history-tab" data-status="pending">
            Menunggu <span class="history-tab__count" data-count="pending">0</span>
        </button>
        <button type="button" class="history-tab" data-status="confirmed">
            Diterima <span class="history-tab__count" data-count="confirmed">0</span>
        </button>
        <button type="button" class="history-tab" data-status="attended">
            Hadir <span class="history-tab__count" data-count="attended">0</span>
        </button>
        <button type="button" class="history-tab" data-status="cancelled">
            Dibatalkan <span class="history-tab__count" data-count="cancelled">0</span>
        </button>
    </div>

    <div class="history-result-row" id="historyResultRow" style="display:none;">
        <span><strong id="historyResultCount">0</strong> kegiatan ditemukan</span>
    </div>

    <div id="historyList">
        @php
            $lastGroupLabel = null;
            $today = \Carbon\Carbon::today();
        @endphp

        @forelse($registrations as $reg)
        @php
            $badgeClass = match($reg->status) {
                'confirmed' => 'history-badge--confirmed',
                'pending'   => 'history-badge--pending',
                'attended'  => 'history-badge--attended',
                default     => 'history-badge--cancelled',
            };
            $badgeLabel = match($reg->status) {
                'confirmed' => 'Diterima',
                'pending'   => 'Menunggu',
                'attended'  => 'Hadir',
                default     => 'Dibatalkan',
            };
            $cardAccentClass = in_array($reg->status, ['confirmed', 'attended'])
                ? 'history-card--' . $reg->status
                : '';

            $eventDate = $reg->event->start_date;
            if ($eventDate->isPast()) {
                $groupLabel = 'Sudah Berlalu';
            } elseif ($eventDate->diffInDays($today) <= 7) {
                $groupLabel = 'Minggu Ini';
            } else {
                $groupLabel = 'Mendatang';
            }

            $searchHaystack = mb_strtolower(
                $reg->event->title . ' ' .
                ($reg->event->organization->organization_name ?? '') . ' ' .
                ($reg->event->city ?? '')
            );
        @endphp

        @if($groupLabel !== $lastGroupLabel)
            <div class="history-group-label" data-group-label>{{ $groupLabel }}</div>
            @php $lastGroupLabel = $groupLabel; @endphp
        @endif

        <article class="history-card {{ $cardAccentClass }}"
                  data-status="{{ $reg->status }}"
                  data-search="{{ $searchHaystack }}">
            <div class="history-card__thumb">
                @if($reg->event->poster)
                    <img src="{{ asset('storage/' . $reg->event->poster) }}"
                         alt="{{ $reg->event->title }}"
                         loading="lazy">
                @else
                    @php $catColor = $reg->event->categories->first()?->color ?? '#3B82F6'; @endphp
                    <div class="history-card__thumb-placeholder"
                         style="background: linear-gradient(135deg, {{ $catColor }}22 0%, {{ $catColor }}55 100%);">
                        <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
                             stroke="{{ $catColor }}" stroke-width="1.5" opacity="0.7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="history-card__body">
                <div class="history-card__cats">
                    @foreach($reg->event->categories->take(2) as $cat)
                        <span class="history-cat-pill">{{ $cat->name }}</span>
                    @endforeach
                </div>

                <h3 class="history-card__title">{{ $reg->event->title }}</h3>

                <p class="history-card__org">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" style="flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    {{ $reg->event->organization->organization_name }}
                </p>

                <div class="history-card__meta">
                    <span class="history-card__meta-item">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $reg->event->city }}
                    </span>
                    <span class="history-card__meta-item">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $reg->event->start_date->format('d M Y') }}
                    </span>
                </div>
            </div>

            <div class="history-card__right">
                <span class="history-badge {{ $badgeClass }}">
                    {{ $badgeLabel }}
                </span>
                <span class="history-card__date">
                    Daftar {{ $reg->registered_at?->format('d M Y') ?? $reg->created_at->format('d M Y') }}
                </span>
            </div>
        </article>
        @empty

        <div class="history-empty">
            <div class="history-empty__icon">
                <svg width="26" height="26" fill="none" viewBox="0 0 24 24"
                     stroke="#3B82F6" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3>Belum ada kegiatan</h3>
            <p>Kamu belum mendaftar ke kegiatan apapun. Yuk mulai berkontribusi!</p>
            <a href="{{ route('volunteer.events') }}" class="btn btn-primary btn-sm">
                Cari Kegiatan
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @endforelse
    </div>

    <div class="history-empty is-hidden" id="historyNoMatch">
        <div class="history-empty__icon">
            <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#3B82F6" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </div>
        <h3>Tidak ada hasil</h3>
        <p>Coba kata kunci lain atau pilih tab status yang berbeda.</p>
    </div>

    <div class="history-pagination">
        {{ $registrations->links() }}
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var searchInput  = document.getElementById('historySearch');
    var searchClear  = document.getElementById('historySearchClear');
    var tabs         = document.querySelectorAll('.history-tab');
    var cards        = document.querySelectorAll('.history-card');
    var groupLabels  = document.querySelectorAll('[data-group-label]');
    var noMatchBox   = document.getElementById('historyNoMatch');
    var resultRow    = document.getElementById('historyResultRow');
    var resultCount  = document.getElementById('historyResultCount');
    var activeStatus = 'all';

    function updateCounts() {
        var counts = { all: cards.length, pending: 0, confirmed: 0, attended: 0, cancelled: 0 };
        cards.forEach(function (card) {
            var status = card.dataset.status;
            if (counts[status] !== undefined) counts[status]++;
        });
        Object.keys(counts).forEach(function (key) {
            var el = document.querySelector('.history-tab__count[data-count="' + key + '"]');
            if (el) el.textContent = counts[key];
        });
    }

    function applyFilters() {
        var query = searchInput.value.trim().toLowerCase();
        searchClear.classList.toggle('is-visible', query.length > 0);

        var visibleCount = 0;

        cards.forEach(function (card) {
            var matchesStatus = activeStatus === 'all' || card.dataset.status === activeStatus;
            var matchesSearch = query === '' || card.dataset.search.indexOf(query) !== -1;
            var show = matchesStatus && matchesSearch;
            card.classList.toggle('is-hidden', !show);
            if (show) visibleCount++;
        });

        groupLabels.forEach(function (label) {
            var sib = label.nextElementSibling;
            var hasVisible = false;
            while (sib && !sib.hasAttribute('data-group-label')) {
                if (sib.classList.contains('history-card') && !sib.classList.contains('is-hidden')) {
                    hasVisible = true;
                    break;
                }
                sib = sib.nextElementSibling;
            }
            label.style.display = hasVisible ? '' : 'none';
        });

        var isFiltering = activeStatus !== 'all' || query !== '';
        noMatchBox.classList.toggle('is-hidden', visibleCount > 0 || !isFiltering);
        resultRow.style.display = isFiltering ? 'flex' : 'none';
        resultCount.textContent = visibleCount;
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('history-tab--active'); });
            tab.classList.add('history-tab--active');
            activeStatus = tab.dataset.status;
            applyFilters();
        });
    });

    searchInput.addEventListener('input', applyFilters);
    searchClear.addEventListener('click', function () {
        searchInput.value = '';
        applyFilters();
        searchInput.focus();
    });

    updateCounts();
    applyFilters();
});
</script>
@endpush