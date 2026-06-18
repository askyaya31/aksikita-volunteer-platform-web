@extends('layouts.admin')

@section('title', 'Laporan — AksiKita Admin')

@section('content')

<div class="ak-page-header">
    <div class="ak-flex-between" style="flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:1.5rem; margin-bottom:4px;">Laporan</h1>
            <p style="margin:0; font-size:0.9rem;">Tinjau dan tindaklanjuti laporan dari pengguna.</p>
        </div>
    </div>
</div>

@php
    $tabs = [
        'open'         => 'Baru',
        'under_review' => 'Sedang Ditinjau',
        'resolved'     => 'Diselesaikan',
        'dismissed'    => 'Diabaikan',
    ];
    $tabColors = [
        'open'         => 'var(--color-danger)',
        'under_review' => 'var(--color-warning)',
        'resolved'     => 'var(--color-success)',
        'dismissed'    => 'var(--color-ink-muted)',
    ];
@endphp

<div style="display:flex; gap:4px; border-bottom:2px solid var(--color-border); margin-bottom:24px; overflow-x:auto; padding-bottom:0;">
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.reports') }}?tab={{ $key }}"
           style="padding:10px 18px; font-size:0.875rem; font-weight:600; white-space:nowrap; border-bottom:2px solid {{ $tab === $key ? $tabColors[$key] : 'transparent' }}; color:{{ $tab === $key ? $tabColors[$key] : 'var(--color-ink-muted)' }}; text-decoration:none; margin-bottom:-2px; transition:all 0.15s; display:inline-flex; align-items:center; gap:7px;">
            {{ $label }}
            @if($counts[$key] > 0)
                <span style="background:{{ $tab === $key ? $tabColors[$key] : 'var(--color-border)' }}; color:{{ $tab === $key ? '#fff' : 'var(--color-ink-muted)' }}; font-size:0.7rem; font-weight:700; padding:1px 7px; border-radius:99px; line-height:1.6; transition:all 0.15s;">
                    {{ $counts[$key] }}
                </span>
            @endif
        </a>
    @endforeach
</div>

<form method="GET" action="{{ route('admin.reports') }}" style="margin-bottom:20px;">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
        <div style="position:relative; flex:1; min-width:200px; max-width:380px;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--color-ink-muted);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="ak-input" placeholder="Cari alasan atau pelapor..."
                   value="{{ request('search') }}" style="padding-left:40px;">
        </div>
        <select name="type" class="ak-input" style="width:auto; min-width:140px;">
            <option value="">Semua Tipe</option>
            <option value="event" {{ request('type') === 'event' ? 'selected' : '' }}>Kegiatan</option>
            <option value="user"  {{ request('type') === 'user'  ? 'selected' : '' }}>Pengguna</option>
        </select>
        <button type="submit" class="ak-btn ak-btn-primary">Filter</button>
        @if(request('search') || request('type'))
            <a href="{{ route('admin.reports') }}?tab={{ $tab }}" class="ak-btn ak-btn-ghost">Reset</a>
        @endif
    </div>
</form>

@if(session('success'))
    <div class="ak-alert ak-alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div class="ak-table-wrapper">
    <table class="ak-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tipe</th>
                <th>Objek Dilaporkan</th>
                <th>Alasan</th>
                <th>Pelapor</th>
                <th>Waktu</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
            @php
                $typeLabel = str_contains($report->reportable_type, 'Event') ? 'Kegiatan' : 'Pengguna';
                $typeBadge = str_contains($report->reportable_type, 'Event') ? 'ak-badge-blue' : 'ak-badge-navy';
                $objectName = '-';
                if ($report->reportable) {
                    $objectName = $report->reportable->title
                        ?? $report->reportable->name
                        ?? "ID #{$report->reportable_id}";
                }
            @endphp
            <tr>
                <td style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                    #{{ $report->id }}
                </td>
                <td>
                    <span class="ak-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
                </td>
                <td style="max-width:200px;">
                    <div style="font-size:0.875rem; font-weight:600; color:var(--color-ink); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Str::limit($objectName, 40) }}
                    </div>
                </td>
                <td style="max-width:220px;">
                    <div style="font-size:0.875rem; color:var(--color-ink-soft); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Str::limit($report->reason, 50) }}
                    </div>
                </td>
                <td>
                    <div style="font-size:0.875rem; color:var(--color-ink-soft);">
                        {{ $report->reporter->name ?? '-' }}
                    </div>
                </td>
                <td>
                    <div style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                        {{ $report->created_at->diffForHumans() }}
                    </div>
                </td>
                <td style="text-align:right;">
                    <a href="{{ route('admin.reports.show', $report->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:48px 24px; color:var(--color-ink-muted);">
                    <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                         style="margin:0 auto 12px; display:block; opacity:0.35;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div style="font-weight:600; margin-bottom:4px;">Tidak ada laporan</div>
                    <div style="font-size:0.85rem;">Belum ada laporan dengan status ini.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($reports->hasPages())
    <div style="margin-top:24px; display:flex; justify-content:center;">
        {{ $reports->links() }}
    </div>
@endif

@endsection