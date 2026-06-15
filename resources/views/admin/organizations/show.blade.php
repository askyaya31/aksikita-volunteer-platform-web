@extends('layouts.admin')

@section('title', ($user->organizationProfile->organization_name ?? $user->name) . ' — Detail Organisasi')

@push('styles')
<style>
.org-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: 18px 20px;
}
.org-field-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--color-ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 2px;
}
.org-field-value {
    font-size: 0.85rem;
    color: var(--color-ink);
}
.org-section-title {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--color-ink-muted);
    margin-bottom: 14px;
}
.org-status-dot {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.775rem;
    font-weight: 500;
}
.org-status-dot::before {
    content: '';
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
}
.org-action-panel {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-left: 3px solid var(--color-warning);
    border-radius: var(--radius-md);
    padding: 16px 18px;
}
.org-divider {
    height: 1px;
    background: var(--color-border-soft);
    margin: 8px 0;
}
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:6px; font-size:0.78rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.users') }}" style="color:var(--color-ink-muted); text-decoration:none;">Pengguna</a>
    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.users') }}?tab=organisasi" style="color:var(--color-ink-muted); text-decoration:none;">Organisasi</a>
    <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink);">{{ $user->organizationProfile->organization_name ?? $user->name }}</span>
</div>

@php $org = $user->organizationProfile; @endphp

{{-- Header --}}
<div style="display:flex; align-items:flex-start; gap:16px; margin-bottom:24px; flex-wrap:wrap;">

    {{-- Logo / inisial --}}
    <div style="width:56px; height:56px; border-radius:var(--radius-md); background:var(--color-blue-ghost); border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
        @if($org?->logo)
            <img src="{{ Storage::url($org->logo) }}" alt="{{ $org->organization_name }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            <span style="font-family:var(--font-display); font-size:1.25rem; font-weight:700; color:var(--color-blue);">
                {{ strtoupper(substr($org->organization_name ?? $user->name, 0, 1)) }}
            </span>
        @endif
    </div>

    <div style="flex:1; min-width:0;">
        {{-- Role + status verifikasi --}}
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:5px;">
            <span style="font-size:0.7rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.08em;">Organisasi</span>
            @if($org)
                @php
                    $vs = $org->verification_status;
                    $vMap = [
                        'pending'  => ['Menunggu Verifikasi', 'var(--color-warning)'],
                        'verified' => ['Terverifikasi', 'var(--color-success)'],
                        'rejected' => ['Ditolak', 'var(--color-danger)'],
                    ];
                    [$vLabel, $vColor] = $vMap[$vs] ?? [$vs, 'var(--color-ink-muted)'];
                @endphp
                <span style="width:3px; height:3px; border-radius:50%; background:var(--color-border); flex-shrink:0;"></span>
                <span class="org-status-dot" style="color:{{ $vColor }};">{{ $vLabel }}</span>
            @endif
            @if(!$user->is_active)
                <span style="width:3px; height:3px; border-radius:50%; background:var(--color-border); flex-shrink:0;"></span>
                <span class="org-status-dot" style="color:var(--color-danger);">Akun Nonaktif</span>
            @endif
        </div>

        <h1 style="font-size:1.25rem; font-weight:700; color:var(--color-ink); margin-bottom:4px; letter-spacing:-0.01em;">
            {{ $org->organization_name ?? $user->name }}
        </h1>
        <div style="font-size:0.825rem; color:var(--color-ink-muted);">
            {{ $user->email }}
            @if($user->phone) · {{ $user->phone }} @endif
            @if($org?->city) · {{ $org->city }}, {{ $org->province }} @endif
        </div>
    </div>

    <a href="{{ route('admin.users') }}?tab=organisasi" class="ak-btn ak-btn-ghost ak-btn-sm" style="flex-shrink:0;">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 320px; gap:20px; align-items:start;">

    {{-- KIRI --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Tentang --}}
        @if($org?->description)
            <div class="org-card">
                <div class="org-section-title">Tentang Organisasi</div>
                <div style="font-size:0.875rem; color:var(--color-ink-soft); line-height:1.75; white-space:pre-wrap;">{{ $org->description }}</div>
            </div>
        @endif

        {{-- Riwayat Kegiatan --}}
        <div class="org-card" style="padding:0; overflow:hidden;">
            <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 18px; border-bottom:1px solid var(--color-border-soft);">
                <div class="org-section-title" style="margin-bottom:0;">Riwayat Kegiatan</div>
                @if($org && $org->events && $org->events->count() > 0)
                    <span style="font-size:0.775rem; color:var(--color-ink-muted);">{{ $org->events->count() }} kegiatan</span>
                @endif
            </div>

            @if($org && $org->events && $org->events->count() > 0)
                <table class="ak-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($org->events->take(10) as $event)
                            @php
                                $sMap = [
                                    'pending_review' => ['Pending',  'var(--color-warning)'],
                                    'published'      => ['Aktif',    'var(--color-success)'],
                                    'completed'      => ['Selesai',  'var(--color-ink-muted)'],
                                    'rejected'       => ['Ditolak',  'var(--color-danger)'],
                                    'draft'          => ['Draft',    'var(--color-ink-muted)'],
                                ];
                                [$sLabel, $sColor] = $sMap[$event->status] ?? [$event->status, 'var(--color-ink-muted)'];
                            @endphp
                            <tr>
                                <td>
                                    <div style="font-weight:500; font-size:0.875rem; color:var(--color-ink);">{{ $event->title }}</div>
                                    <div style="font-size:0.75rem; color:var(--color-ink-muted); margin-top:1px;">{{ $event->city }}</div>
                                </td>
                                <td style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                </td>
                                <td style="font-size:0.8rem; color:var(--color-ink-muted);">
                                    {{ $event->quota }}
                                </td>
                                <td>
                                    <span class="org-status-dot" style="color:{{ $sColor }};">{{ $sLabel }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.events.show', $event->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="ak-empty-state" style="padding:36px 0;">
                    <div class="ak-empty-state__icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>Belum ada kegiatan</h3>
                    <p>Organisasi ini belum pernah membuat kegiatan.</p>
                </div>
            @endif
        </div>

        {{-- Alasan penolakan --}}
        @if($org?->verification_status === 'rejected' && $org->rejection_reason)
            <div class="ak-alert ak-alert-danger">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600; margin-bottom:2px;">Alasan Penolakan</div>
                    <div>{{ $org->rejection_reason }}</div>
                </div>
            </div>
        @endif

    </div>

    {{-- KANAN --}}
    <div style="display:flex; flex-direction:column; gap:14px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        {{-- Panel verifikasi pending --}}
        @if($org && $org->verification_status === 'pending')
            <div class="org-action-panel">
                <div style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--color-ink-muted); margin-bottom:4px;">Tindakan Diperlukan</div>
                <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:14px; line-height:1.5;">
                    Tinjau profil organisasi sebelum mengambil keputusan.
                </p>

                <form method="POST" action="{{ route('admin.users.verify-organization', $org->id) }}" style="margin-bottom:8px;">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="ak-btn ak-btn-success ak-btn-sm" style="width:100%; justify-content:center;"
                            onclick="return confirm('Verifikasi organisasi ini?')">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Setujui Verifikasi
                    </button>
                </form>

                <button type="button" onclick="document.getElementById('orgRejectForm').classList.toggle('hidden')"
                        class="ak-btn ak-btn-ghost ak-btn-sm" style="width:100%; justify-content:center; color:var(--color-danger); border-color:var(--color-danger);">
                    Tolak Verifikasi
                </button>

                <div id="orgRejectForm" class="hidden" style="margin-top:14px; padding-top:14px; border-top:1px solid var(--color-border);">
                    <form method="POST" action="{{ route('admin.users.verify-organization', $org->id) }}">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <div class="ak-form-group" style="margin-bottom:10px;">
                            <label class="ak-label" for="rejection_reason_org">Alasan Penolakan <span class="required">*</span></label>
                            <textarea name="rejection_reason" id="rejection_reason_org" class="ak-textarea" rows="4"
                                      placeholder="Contoh: Dokumen akta pendirian tidak dilampirkan. Silakan lengkapi dan ajukan ulang."
                                      required></textarea>
                            <span class="ak-input-hint">Dikirim ke organisasi melalui notifikasi.</span>
                        </div>
                        <button type="submit" class="ak-btn ak-btn-danger ak-btn-sm" style="width:100%; justify-content:center;"
                                onclick="return confirm('Tolak verifikasi organisasi ini?')">
                            Konfirmasi Penolakan
                        </button>
                    </form>
                </div>
            </div>

        @elseif($org && $org->verification_status === 'verified')
            <div class="ak-alert ak-alert-success" style="padding:12px 14px;">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600; font-size:0.875rem;">Sudah Terverifikasi</div>
                    @if($org->verified_at)
                        <div style="font-size:0.775rem; margin-top:1px;">Sejak {{ \Carbon\Carbon::parse($org->verified_at)->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Informasi akun --}}
        <div class="org-card">
            <div class="org-section-title">Informasi Akun</div>
            <div style="display:flex; flex-direction:column; gap:10px;">

                <div>
                    <div class="org-field-label">Nama Pengguna</div>
                    <div class="org-field-value">{{ $user->name }}</div>
                </div>
                <div>
                    <div class="org-field-label">Email</div>
                    <div class="org-field-value">{{ $user->email }}</div>
                </div>
                @if($user->phone)
                    <div>
                        <div class="org-field-label">Telepon</div>
                        <div class="org-field-value">{{ $user->phone }}</div>
                    </div>
                @endif
                <div>
                    <div class="org-field-label">Bergabung</div>
                    <div class="org-field-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
                </div>

                @if($org)
                    <div class="org-divider"></div>

                    @if($org->address)
                        <div>
                            <div class="org-field-label">Alamat</div>
                            <div class="org-field-value">{{ $org->address }}</div>
                            <div style="font-size:0.8rem; color:var(--color-ink-muted); margin-top:1px;">{{ $org->city }}, {{ $org->province }}</div>
                        </div>
                    @endif
                    @if($org->website)
                        <div>
                            <div class="org-field-label">Website</div>
                            <a href="{{ $org->website }}" target="_blank" style="font-size:0.85rem; color:var(--color-blue);">{{ $org->website }}</a>
                        </div>
                    @endif
                    @if($org->verified_at)
                        <div>
                            <div class="org-field-label">Diverifikasi</div>
                            <div style="font-size:0.85rem; color:var(--color-success);">{{ \Carbon\Carbon::parse($org->verified_at)->format('d M Y') }}</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Status akun --}}
        @if($user->role !== 'admin')
            <div class="org-card">
                <div class="org-section-title">Status Akun</div>
                <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:12px; line-height:1.5;">
                    {{ $user->is_active ? 'Pengguna dapat login dan menggunakan platform.' : 'Akun dinonaktifkan. Pengguna tidak dapat login.' }}
                </p>
                <button type="button"
                        onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }}, this)"
                        class="ak-btn ak-btn-sm {{ $user->is_active ? 'ak-btn-ghost' : 'ak-btn-success' }}"
                        style="width:100%; justify-content:center; {{ $user->is_active ? 'color:var(--color-danger); border-color:var(--color-danger);' : '' }}">
                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                </button>
            </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('orgRejectForm')?.classList.add('hidden');

async function toggleUserActive(userId, currentlyActive, btn) {
    if (!confirm(currentlyActive
        ? 'Nonaktifkan akun organisasi ini?'
        : 'Aktifkan kembali akun organisasi ini?'
    )) return;
    btn.disabled = true;
    try {
        const res = await fetch(`/api/admin/users/${userId}/toggle-active`, {
            method: 'PATCH',
            headers: { 'Accept': 'application/json' },
        });
        if (res.ok) {
            window.location.reload();
        } else {
            const d = await res.json();
            alert(d.message ?? 'Gagal mengubah status.');
            btn.disabled = false;
        }
    } catch {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btn.disabled = false;
    }
}
</script>
<style>.hidden { display: none !important; }</style>
@endpush