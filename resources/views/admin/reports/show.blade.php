@extends('layouts.admin')

@section('title', 'Detail Laporan #' . $report->id . ' — AksiKita Admin')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.reports') }}" style="color:var(--color-ink-muted); text-decoration:none;">Laporan</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
    <span style="color:var(--color-ink);">Laporan #{{ $report->id }}</span>
</div>

{{-- Header --}}
@php
    $statusMap = [
        'open'         => ['label' => 'Baru',             'class' => 'ak-badge-danger'],
        'under_review' => ['label' => 'Sedang Ditinjau',  'class' => 'ak-badge-warning'],
        'resolved'     => ['label' => 'Diselesaikan',     'class' => 'ak-badge-success'],
        'dismissed'    => ['label' => 'Diabaikan',        'class' => 'ak-badge-gray'],
    ];
    $s         = $statusMap[$report->status] ?? ['label' => $report->status, 'class' => 'ak-badge-gray'];
    $typeLabel = str_contains($report->reportable_type, 'Event') ? 'Kegiatan' : 'Pengguna';
    $typeBadge = str_contains($report->reportable_type, 'Event') ? 'ak-badge-blue' : 'ak-badge-navy';
    $objectName = '-';
    if ($report->reportable) {
        $objectName = $report->reportable->title ?? $report->reportable->name ?? "ID #{$report->reportable_id}";
    }
    $canAct = in_array($report->status, ['open', 'under_review']);
@endphp

<div class="ak-flex-between" style="flex-wrap:wrap; gap:16px; margin-bottom:28px;">
    <div>
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
            <span class="ak-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
            <span class="ak-badge {{ $typeBadge }}">{{ $typeLabel }}</span>
        </div>
        <h1 style="font-size:1.4rem; margin:0;">Laporan #{{ $report->id }}</h1>
    </div>
    <a href="{{ route('admin.reports') }}?tab={{ $report->status }}" class="ak-btn ak-btn-ghost">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

@if(session('success'))
    <div class="ak-alert ak-alert-success" style="margin-bottom:20px;">{{ session('success') }}</div>
@endif

<div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

    {{-- Left column --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Objek dilaporkan --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.875rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.05em; margin:0 0 14px;">
                Objek Dilaporkan
            </h3>
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:42px; height:42px; border-radius:12px; background:var(--color-surface); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    @if(str_contains($report->reportable_type, 'Event'))
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--color-brand)" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @else
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--color-brand)" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <div style="font-weight:600; font-size:0.925rem; color:var(--color-ink);">{{ $objectName }}</div>
                    <div style="font-size:0.8rem; color:var(--color-ink-muted); margin-top:2px;">
                        {{ $typeLabel }} &middot; ID #{{ $report->reportable_id }}
                    </div>
                </div>
                @if($report->reportable)
                    @if(str_contains($report->reportable_type, 'Event'))
                        <a href="{{ route('admin.events.show', $report->reportable_id) }}"
                           class="ak-btn ak-btn-ghost ak-btn-sm" style="margin-left:auto;">
                            Lihat Kegiatan
                        </a>
                    @else
                        @php $role = $report->reportable->role ?? 'volunteer'; @endphp
                        <a href="{{ $role === 'organization' ? route('admin.organizations.show', $report->reportable_id) : route('admin.volunteers.show', $report->reportable_id) }}"
                           class="ak-btn ak-btn-ghost ak-btn-sm" style="margin-left:auto;">
                            Lihat Profil
                        </a>
                    @endif
                @endif
            </div>
        </div>

        {{-- Alasan & deskripsi --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.875rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.05em; margin:0 0 14px;">
                Isi Laporan
            </h3>
            <div style="margin-bottom:12px;">
                <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:4px;">Alasan</div>
                <div style="font-size:0.9rem; font-weight:600; color:var(--color-ink);">{{ $report->reason }}</div>
            </div>
            @if($report->description)
                <div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:4px;">Keterangan Tambahan</div>
                    <div style="font-size:0.875rem; color:var(--color-ink-soft); line-height:1.7; white-space:pre-wrap;">{{ $report->description }}</div>
                </div>
            @else
                <div style="font-size:0.85rem; color:var(--color-ink-muted); font-style:italic;">Tidak ada keterangan tambahan.</div>
            @endif
        </div>

        {{-- Catatan admin (jika sudah ditangani) --}}
        @if($report->admin_notes)
            <div class="ak-card-flat" style="border-color:var(--color-success); background:var(--color-success-bg, #F0FDF4);">
                <h3 style="font-size:0.875rem; font-weight:700; color:var(--color-success); text-transform:uppercase; letter-spacing:0.05em; margin:0 0 10px;">
                    Catatan Admin
                </h3>
                <div style="font-size:0.875rem; color:var(--color-ink-soft); line-height:1.7; white-space:pre-wrap;">{{ $report->admin_notes }}</div>
                @if($report->resolvedBy)
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-top:10px;">
                        Oleh {{ $report->resolvedBy->name }}
                        &middot;
                        {{ $report->resolved_at?->diffForHumans() }}
                    </div>
                @endif
            </div>
        @endif

    </div>

    {{-- Right column --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Info singkat --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.875rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.05em; margin:0 0 14px;">
                Info Laporan
            </h3>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:3px;">Pelapor</div>
                    <div style="font-size:0.875rem; font-weight:600; color:var(--color-ink);">
                        {{ $report->reporter->name ?? '-' }}
                    </div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted);">
                        {{ $report->reporter->email ?? '' }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:3px;">Dilaporkan pada</div>
                    <div style="font-size:0.875rem; color:var(--color-ink-soft);">
                        {{ $report->created_at->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:3px;">Status</div>
                    <span class="ak-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                </div>
            </div>
        </div>

        {{-- Aksi admin --}}
        @if($canAct)
            <div class="ak-card-flat">
                <h3 style="font-size:0.875rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.05em; margin:0 0 14px;">
                    Tindakan Admin
                </h3>
                <form action="{{ route('admin.reports.update', ['id' => $report->id]) }}" method="POST"
                      id="reportActionForm">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom:14px;">
                        <label style="font-size:0.82rem; font-weight:600; color:var(--color-ink); display:block; margin-bottom:6px;">
                            Catatan (opsional)
                        </label>
                        <textarea name="admin_notes" class="ak-input" rows="3"
                                  placeholder="Tuliskan catatan penanganan..."
                                  style="resize:vertical; font-size:0.875rem;">{{ old('admin_notes') }}</textarea>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;">
                        @if($report->status === 'open')
                            <button type="submit" name="action" value="under_review"
                                    class="ak-btn ak-btn-primary" style="width:100%; justify-content:center;">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Tandai Sedang Ditinjau
                            </button>
                        @endif
                        <button type="submit" name="action" value="resolve"
                                class="ak-btn ak-btn-success" style="width:100%; justify-content:center;">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Selesaikan Laporan
                        </button>
                        <button type="submit" name="action" value="dismiss"
                                class="ak-btn ak-btn-ghost" style="width:100%; justify-content:center; color:var(--color-ink-muted);"
                                onclick="return confirm('Abaikan laporan ini?')">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Abaikan Laporan
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="ak-card-flat" style="text-align:center; padding:20px;">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                     style="margin:0 auto 8px; display:block; opacity:0.3;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div style="font-size:0.85rem; color:var(--color-ink-muted);">Laporan ini sudah ditangani.</div>
            </div>
        @endif

    </div>
</div>

@endsection