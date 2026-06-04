@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Page header --}}
<div class="ak-page-header">
    <div class="ak-flex-between" style="flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:1.5rem; margin-bottom:4px;">Selamat datang, {{ session('user_name') }}</h1>
            <p style="margin:0; font-size:0.9rem;">Pantau aktivitas platform AksiKita dari sini.</p>
        </div>
        <div style="font-size:0.8rem; color:var(--color-ink-muted); background:var(--color-border-soft); padding:6px 14px; border-radius:var(--radius-full);">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
</div>

<div class="ak-grid-4" style="margin-bottom:32px;">

    <div class="ak-stat-card">
        <div class="ak-stat-icon navy">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div>
            <div class="ak-stat-value">{{ number_format($stats['total_users']) }}</div>
            <div class="ak-stat-label">Total Pengguna</div>
            <div style="margin-top:6px; display:flex; gap:8px; flex-wrap:wrap;">
                <span class="ak-badge ak-badge-blue">{{ number_format($stats['total_volunteers']) }} Volunteer</span>
                <span class="ak-badge ak-badge-navy">{{ number_format($stats['total_organizations']) }} Org</span>
            </div>
        </div>
    </div>

    <div class="ak-stat-card">
        <div class="ak-stat-icon blue">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="ak-stat-value">{{ number_format($stats['total_events']) }}</div>
            <div class="ak-stat-label">Total Kegiatan</div>
            <div style="margin-top:6px; display:flex; gap:8px; flex-wrap:wrap;">
                <span class="ak-badge ak-badge-success">{{ number_format($stats['published_events']) }} Aktif</span>
                <span class="ak-badge ak-badge-warning">{{ number_format($stats['pending_events']) }} Pending</span>
            </div>
        </div>
    </div>

    <div class="ak-stat-card">
        <div class="ak-stat-icon success">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <div class="ak-stat-value">{{ number_format($stats['total_registrations']) }}</div>
            <div class="ak-stat-label">Total Pendaftaran</div>
        </div>
    </div>

    <div class="ak-stat-card" style="{{ $stats['pending_org'] > 0 ? 'border-color:var(--color-warning); background:var(--color-warning-bg);' : '' }}">
        <div class="ak-stat-icon warning">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <div class="ak-stat-value" style="{{ $stats['pending_org'] > 0 ? 'color:var(--color-warning);' : '' }}">{{ number_format($stats['pending_org']) }}</div>
            <div class="ak-stat-label">Organisasi Pending</div>
            @if($stats['pending_org'] > 0)
                <div style="margin-top:6px;">
                    <a href="{{ route('admin.users') }}?tab=organisasi" class="ak-badge ak-badge-warning" style="font-size:11px;">Tinjau sekarang</a>
                </div>
            @endif
        </div>
    </div>

</div>


<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
    {{-- Organisasi menunggu verifikasi --}}
    <div class="ak-card-flat">
        <div class="ak-flex-between" style="margin-bottom:20px;">
            <div>
                <h3 style="font-size:1rem; margin-bottom:2px;">Organisasi Menunggu Verifikasi</h3>
                @if($pendingOrgs->count() > 0)
                    <p style="font-size:0.8rem; margin:0;">{{ $pendingOrgs->count() }} organisasi perlu ditinjau</p>
                @else
                    <p style="font-size:0.8rem; margin:0; color:var(--color-success);">Semua sudah ditinjau</p>
                @endif
            </div>
            <a href="{{ route('admin.users') }}?tab=organisasi" class="ak-btn ak-btn-ghost ak-btn-sm">
                Lihat semua
            </a>
        </div>

        @if($pendingOrgs->isEmpty())
            <div class="ak-empty-state" style="padding:32px 16px;">
                <div class="ak-empty-state__icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Tidak ada antrian</h3>
                <p>Semua organisasi sudah diproses.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1px;">
                @foreach($pendingOrgs as $org)
                    <div style="display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--color-border-soft);">
                        {{-- Logo / avatar org --}}
                        <div style="width:36px; height:36px; border-radius:var(--radius-sm); background:var(--color-blue-ghost); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-family:var(--font-display); font-weight:700; font-size:14px; color:var(--color-navy);">
                            {{ strtoupper(substr($org->organization_name ?? $org->user->name, 0, 1)) }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:600; font-size:0.875rem; color:var(--color-ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $org->organization_name ?? $org->user->name }}
                            </div>
                            <div style="font-size:0.78rem; color:var(--color-ink-muted);">
                                {{ $org->user->email }} · {{ $org->city ?? '-' }}
                            </div>
                        </div>
                        <div style="flex-shrink:0;">
                            <span class="ak-badge ak-badge-warning">Pending</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Event menunggu review --}}
    <div class="ak-card-flat">
        <div class="ak-flex-between" style="margin-bottom:20px;">
            <div>
                <h3 style="font-size:1rem; margin-bottom:2px;">Kegiatan Menunggu Review</h3>
                @if($pendingEvents->count() > 0)
                    <p style="font-size:0.8rem; margin:0;">{{ $pendingEvents->count() }} kegiatan perlu ditinjau</p>
                @else
                    <p style="font-size:0.8rem; margin:0; color:var(--color-success);">Tidak ada antrian</p>
                @endif
            </div>
            <a href="{{ route('admin.events') }}?tab=review" class="ak-btn ak-btn-ghost ak-btn-sm">
                Lihat semua
            </a>
        </div>

        @if($pendingEvents->isEmpty())
            <div class="ak-empty-state" style="padding:32px 16px;">
                <div class="ak-empty-state__icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3>Tidak ada antrian</h3>
                <p>Semua kegiatan sudah diproses.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1px;">
                @foreach($pendingEvents as $event)
                    <div style="display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid var(--color-border-soft);">
                        <div style="width:36px; height:36px; border-radius:var(--radius-sm); background:linear-gradient(135deg, var(--color-blue-ghost) 0%, var(--color-blue-pale) 100%); display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--color-blue);">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:600; font-size:0.875rem; color:var(--color-ink); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $event->title }}
                            </div>
                            <div style="font-size:0.78rem; color:var(--color-ink-muted);">
                                {{ $event->organization->organization_name ?? '-' }} · {{ $event->city }}
                            </div>
                        </div>
                        <a href="{{ route('admin.events.show', $event->id) }}" class="ak-btn ak-btn-primary ak-btn-sm" style="flex-shrink:0;">
                            Tinjau
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection