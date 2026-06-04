@extends('layouts.admin')

@section('title', 'Kelola Kegiatan')

@section('content')

<div class="ak-page-header">
    <div class="ak-flex-between" style="flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:1.5rem; margin-bottom:4px;">Kelola Kegiatan</h1>
            <p style="margin:0; font-size:0.9rem;">Tinjau dan kelola semua kegiatan yang masuk ke platform.</p>
        </div>
    </div>
</div>

<div style="display:flex; gap:4px; border-bottom:2px solid var(--color-border); margin-bottom:24px; overflow-x:auto; padding-bottom:0;">
    @php
        $tabs = [
            'review'  => 'Menunggu Review',
            'aktif'   => 'Aktif / Published',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $tabColors = [
            'review'  => 'var(--color-warning)',
            'aktif'   => 'var(--color-success)',
            'selesai' => 'var(--color-ink-muted)',
            'ditolak' => 'var(--color-danger)',
        ];
    @endphp
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.events') }}?tab={{ $key }}{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
           style="padding:10px 18px; font-size:0.875rem; font-weight:600; white-space:nowrap; border-bottom:2px solid {{ $tab === $key ? $tabColors[$key] : 'transparent' }}; color:{{ $tab === $key ? $tabColors[$key] : 'var(--color-ink-muted)' }}; text-decoration:none; margin-bottom:-2px; transition:all 0.15s;">
            {{ $label }}
        </a>
    @endforeach
</div>

<form method="GET" action="{{ route('admin.events') }}" style="margin-bottom:20px;">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div style="display:flex; gap:8px; max-width:480px;">
        <div style="position:relative; flex:1;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--color-ink-muted);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="ak-input" placeholder="Cari judul kegiatan..." value="{{ request('search') }}"
                   style="padding-left:40px;">
        </div>
        <button type="submit" class="ak-btn ak-btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.events') }}?tab={{ $tab }}" class="ak-btn ak-btn-ghost">Reset</a>
        @endif
    </div>
</form>

<div class="ak-table-wrapper">
    <table class="ak-table">
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Organisasi</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Kuota</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr>
                    <td style="max-width:240px;">
                        <div style="font-weight:600; font-size:0.875rem; color:var(--color-ink); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:220px;">
                            {{ $event->title }}
                        </div>
                        <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:2px;">
                            Dibuat {{ $event->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.875rem; color:var(--color-ink-soft);">
                            {{ $event->organization->organization_name ?? '-' }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.875rem; color:var(--color-ink-soft);">
                            {{ $event->city }}, {{ $event->province }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.875rem; color:var(--color-ink-soft); white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                        </div>
                    </td>
                    <td>
                        <div style="font-size:0.875rem; color:var(--color-ink-soft);">
                            {{ $event->registered_count ?? 0 }}/{{ $event->quota }}
                        </div>
                    </td>
                    <td>
                        @php
                            $statusMap = [
                                'pending_review' => ['label'=>'Pending', 'class'=>'ak-badge-warning'],
                                'published'      => ['label'=>'Aktif', 'class'=>'ak-badge-success'],
                                'completed'      => ['label'=>'Selesai', 'class'=>'ak-badge-gray'],
                                'rejected'       => ['label'=>'Ditolak', 'class'=>'ak-badge-danger'],
                                'draft'          => ['label'=>'Draft', 'class'=>'ak-badge-gray'],
                                'cancelled'      => ['label'=>'Dibatalkan', 'class'=>'ak-badge-danger'],
                            ];
                            $s = $statusMap[$event->status] ?? ['label'=>$event->status, 'class'=>'ak-badge-gray'];
                        @endphp
                        <span class="ak-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.events.show', $event->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="padding:0; border:none;">
                        <div class="ak-empty-state">
                            <div class="ak-empty-state__icon">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3>Tidak ada kegiatan</h3>
                            <p>
                                @if(request('search'))
                                    Tidak ada kegiatan yang cocok dengan pencarian "{{ request('search') }}".
                                @else
                                    Belum ada kegiatan dengan status ini.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($events->hasPages())
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; flex-wrap:wrap; gap:12px;">
        <div style="font-size:0.85rem; color:var(--color-ink-muted);">
            Menampilkan {{ $events->firstItem() }}–{{ $events->lastItem() }} dari {{ $events->total() }} kegiatan
        </div>
        <div class="ak-pagination">
            @if($events->onFirstPage())
                <span class="disabled">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $events->previousPageUrl() }}">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
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
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="disabled">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
    </div>
@endif

@endsection