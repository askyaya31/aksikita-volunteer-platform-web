@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')

@section('content')

<div style="margin-bottom: 28px;">
    <h1 style="font-size: 1.35rem; font-weight: 700; color: var(--color-ink); margin-bottom: 4px;">Kelola Kegiatan</h1>
    <p style="font-size: 0.875rem; color: var(--color-ink-muted); margin: 0;">Tinjau dan kelola semua kegiatan yang masuk ke platform.</p>
</div>

<div style="display: flex; gap: 0; border-bottom: 1px solid var(--color-border); margin-bottom: 24px; overflow-x: auto;">
    @php
        $tabs = [
            'review'  => 'Menunggu Review',
            'aktif'   => 'Aktif',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];
        $activeColor = [
            'review'  => '#92400E',
            'aktif'   => '#14532D',
            'selesai' => '#374151',
            'ditolak' => '#7F1D1D',
        ];
        $activeBg = [
            'review'  => '#FEF3C7',
            'aktif'   => '#DCFCE7',
            'selesai' => '#F3F4F6',
            'ditolak' => '#FEE2E2',
        ];
    @endphp
    @foreach($tabs as $key => $label)
        @php $isActive = $tab === $key; @endphp
        <a href="{{ route('admin.events') }}?tab={{ $key }}{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
           style="
               padding: 10px 20px;
               font-size: 0.85rem;
               font-weight: {{ $isActive ? '600' : '500' }};
               white-space: nowrap;
               text-decoration: none;
               border-bottom: 2px solid {{ $isActive ? $activeColor[$key] : 'transparent' }};
               color: {{ $isActive ? $activeColor[$key] : 'var(--color-ink-muted)' }};
               margin-bottom: -1px;
               transition: color 0.15s, border-color 0.15s;
           ">
            {{ $label }}
        </a>
    @endforeach
</div>


<form method="GET" action="{{ route('admin.events') }}" style="margin-bottom: 20px;">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div style="display: flex; gap: 8px; max-width: 420px;">
        <div style="position: relative; flex: 1;">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--color-ink-muted); pointer-events: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="ak-input" placeholder="Cari judul kegiatan..."
                   value="{{ request('search') }}" style="padding-left: 36px;">
        </div>
        <button type="submit" class="ak-btn ak-btn-primary" style="padding: 0 16px;">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.events') }}?tab={{ $tab }}" class="ak-btn ak-btn-ghost">Hapus</a>
        @endif
    </div>
</form>

<div class="ak-table-wrapper">
    <table class="ak-table">
        <thead>
            <tr>
                <th>Judul Kegiatan</th>
                <th>Organisasi</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Kuota</th>
                <th>Status</th>
                <th style="text-align: right; width: 80px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td style="max-width: 260px;">
                        <div style="font-weight: 600; font-size: 0.875rem; color: var(--color-ink);
                                    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $event->title }}
                        </div>
                        <div style="font-size: 0.78rem; color: var(--color-ink-muted); margin-top: 2px;">
                            {{ $event->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td style="font-size: 0.875rem; color: var(--color-ink-soft);">
                        {{ $event->organization->organization_name ?? '-' }}
                    </td>
                    <td style="font-size: 0.875rem; color: var(--color-ink-soft); white-space: nowrap;">
                        {{ $event->city }}
                    </td>
                    <td style="font-size: 0.875rem; color: var(--color-ink-soft); white-space: nowrap;">
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                    </td>
                    <td style="font-size: 0.875rem; color: var(--color-ink-soft);">
                        {{ $event->registered_count ?? 0 }}/{{ $event->quota }}
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pending_review' => ['label' => 'Menunggu Review', 'class' => 'ak-badge-warning'],
                                'published'      => ['label' => 'Aktif',           'class' => 'ak-badge-success'],
                                'completed'      => ['label' => 'Selesai',         'class' => 'ak-badge-gray'],
                                'rejected'       => ['label' => 'Ditolak',         'class' => 'ak-badge-danger'],
                                'draft'          => ['label' => 'Draft',           'class' => 'ak-badge-gray'],
                                'cancelled'      => ['label' => 'Dibatalkan',      'class' => 'ak-badge-danger'],
                            ];
                            $s = $statusMap[$event->status] ?? ['label' => $event->status, 'class' => 'ak-badge-gray'];
                        @endphp
                        <span class="ak-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.events.show', $event->id) }}"
                           class="ak-btn ak-btn-ghost ak-btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding: 48px 24px; text-align: center; border: none;">
                        <div style="color: var(--color-ink-muted); font-size: 0.875rem;">
                            @if(request('search'))
                                Tidak ada kegiatan yang cocok dengan pencarian
                                <strong>"{{ request('search') }}"</strong>.
                            @else
                                Belum ada kegiatan dengan status ini.
                            @endif
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($events->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center;
                margin-top: 20px; flex-wrap: wrap; gap: 12px;">
        <div style="font-size: 0.8rem; color: var(--color-ink-muted);">
            Menampilkan {{ $events->firstItem() }}–{{ $events->lastItem() }}
            dari {{ $events->total() }} kegiatan
        </div>
        <div class="ak-pagination">
            @if($events->onFirstPage())
                <span class="disabled">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $events->previousPageUrl() }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            @foreach($events->getUrlRange(max(1, $events->currentPage()-2), min($events->lastPage(), $events->currentPage()+2)) as $page => $url)
                @if($page === $events->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($events->hasMorePages())
                <a href="{{ $events->nextPageUrl() }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="disabled">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif

@endsection