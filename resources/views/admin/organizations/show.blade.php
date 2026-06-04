@extends('layouts.admin')

@section('title', ($user->organizationProfile->organization_name ?? $user->name) . ' — Detail Organisasi')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:20px;">
    <a href="{{ route('admin.users') }}" style="color:var(--color-ink-muted); text-decoration:none;">Pengguna</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('admin.users') }}?tab=organisasi" style="color:var(--color-ink-muted); text-decoration:none;">Organisasi</a>
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    <span style="color:var(--color-ink);">{{ $user->organizationProfile->organization_name ?? $user->name }}</span>
</div>

@php $org = $user->organizationProfile; @endphp

{{-- Header --}}
<div style="display:flex; align-items:flex-start; gap:20px; margin-bottom:28px; flex-wrap:wrap;">
    {{-- Logo --}}
    <div style="width:72px; height:72px; border-radius:var(--radius-md); background:var(--color-blue-ghost); border:1.5px solid var(--color-border); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
        @if($org?->logo)
            <img src="{{ Storage::url($org->logo) }}" alt="{{ $org->organization_name }}" style="width:100%; height:100%; object-fit:cover;">
        @else
            <span style="font-family:var(--font-display); font-size:2rem; font-weight:800; color:var(--color-navy);">
                {{ strtoupper(substr($org->organization_name ?? $user->name, 0, 1)) }}
            </span>
        @endif
    </div>

    <div style="flex:1; min-width:0;">
        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:6px;">
            <span class="ak-badge ak-badge-navy">Organisasi</span>
            @if($org)
                @php
                    $vs = $org->verification_status;
                    $vMap = [
                        'pending'  => ['Menunggu Verifikasi', 'ak-badge-warning'],
                        'verified' => ['Terverifikasi', 'ak-badge-success'],
                        'rejected' => ['Ditolak', 'ak-badge-danger'],
                    ];
                    [$vLabel, $vClass] = $vMap[$vs] ?? [$vs, 'ak-badge-gray'];
                @endphp
                <span class="ak-badge {{ $vClass }}">{{ $vLabel }}</span>
            @endif
            @if(!$user->is_active)
                <span class="ak-badge ak-badge-danger">Akun Nonaktif</span>
            @endif
        </div>
        <h1 style="font-size:1.5rem; margin-bottom:4px;">{{ $org->organization_name ?? $user->name }}</h1>
        <div style="font-size:0.875rem; color:var(--color-ink-muted);">
            {{ $user->email }}
            @if($user->phone) · {{ $user->phone }} @endif
            @if($org?->city) · {{ $org->city }}, {{ $org->province }} @endif
        </div>
    </div>

    <a href="{{ route('admin.users') }}?tab=organisasi" class="ak-btn ak-btn-ghost" style="flex-shrink:0;">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>

<div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

    {{-- LEFT --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Tentang organisasi --}}
        @if($org?->description)
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:12px;">Tentang Organisasi</h3>
                <div style="font-size:0.9rem; color:var(--color-ink-soft); line-height:1.75; white-space:pre-wrap;">{{ $org->description }}</div>
            </div>
        @endif

        {{-- Kegiatan yang pernah dibuat --}}
        @if($org && $org->events && $org->events->count() > 0)
            <div class="ak-card-flat">
                <div class="ak-flex-between" style="margin-bottom:16px;">
                    <h3 style="font-size:0.95rem; margin-bottom:0;">Riwayat Kegiatan</h3>
                    <span class="ak-badge ak-badge-blue">{{ $org->events->count() }} kegiatan</span>
                </div>
                <div class="ak-table-wrapper">
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
                                        'pending_review' => ['Pending', 'ak-badge-warning'],
                                        'published'      => ['Aktif', 'ak-badge-success'],
                                        'completed'      => ['Selesai', 'ak-badge-gray'],
                                        'rejected'       => ['Ditolak', 'ak-badge-danger'],
                                        'draft'          => ['Draft', 'ak-badge-gray'],
                                    ];
                                    [$sLabel, $sClass] = $sMap[$event->status] ?? [$event->status, 'ak-badge-gray'];
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight:500; font-size:0.875rem; color:var(--color-ink);">{{ $event->title }}</div>
                                        <div style="font-size:0.78rem; color:var(--color-ink-muted);">{{ $event->city }}</div>
                                    </td>
                                    <td style="font-size:0.8rem; color:var(--color-ink-muted); white-space:nowrap;">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}
                                    </td>
                                    <td style="font-size:0.8rem; color:var(--color-ink-muted);">
                                        {{ $event->quota }}
                                    </td>
                                    <td>
                                        <span class="ak-badge {{ $sClass }}">{{ $sLabel }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.events.show', $event->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:12px;">Riwayat Kegiatan</h3>
                <div class="ak-empty-state" style="padding:32px 0;">
                    <div class="ak-empty-state__icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>Belum ada kegiatan</h3>
                    <p>Organisasi ini belum pernah membuat kegiatan.</p>
                </div>
            </div>
        @endif

        {{-- Alasan penolakan sebelumnya --}}
        @if($org?->verification_status === 'rejected' && $org->rejection_reason)
            <div class="ak-alert ak-alert-danger">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600; margin-bottom:2px;">Alasan Penolakan</div>
                    <div>{{ $org->rejection_reason }}</div>
                </div>
            </div>
        @endif

    </div>

    {{-- RIGHT --}}
    <div style="display:flex; flex-direction:column; gap:20px; position:sticky; top:calc(var(--spacing-navbar) + 16px);">

        {{-- Info akun --}}
        <div class="ak-card-flat">
            <h3 style="font-size:0.95rem; margin-bottom:16px;">Informasi Akun</h3>
            <div style="display:flex; flex-direction:column; gap:12px;">

                <div>
                    <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Nama Pengguna</div>
                    <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->name }}</div>
                </div>
                <div>
                    <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Email</div>
                    <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->email }}</div>
                </div>
                @if($user->phone)
                    <div>
                        <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Telepon</div>
                        <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->phone }}</div>
                    </div>
                @endif
                <div>
                    <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Bergabung</div>
                    <div style="font-size:0.875rem; color:var(--color-ink);">{{ $user->created_at->format('d M Y, H:i') }}</div>
                </div>

                @if($org)
                    <hr class="ak-divider" style="margin:4px 0;">

                    @if($org->address)
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Alamat</div>
                            <div style="font-size:0.875rem; color:var(--color-ink);">{{ $org->address }}</div>
                            <div style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $org->city }}, {{ $org->province }}</div>
                        </div>
                    @endif
                    @if($org->website)
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Website</div>
                            <a href="{{ $org->website }}" target="_blank" style="font-size:0.875rem;">{{ $org->website }}</a>
                        </div>
                    @endif
                    @if($org->verified_at)
                        <div>
                            <div style="font-size:0.75rem; font-weight:700; color:var(--color-ink-muted); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:3px;">Diverifikasi</div>
                            <div style="font-size:0.875rem; color:var(--color-success);">{{ \Carbon\Carbon::parse($org->verified_at)->format('d M Y') }}</div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Panel aksi verifikasi (hanya jika pending) --}}
        @if($org && $org->verification_status === 'pending')
            <div class="ak-card-flat" style="border-color:var(--color-warning); background:var(--color-warning-bg);">
                <h3 style="font-size:0.95rem; margin-bottom:4px;">Verifikasi Organisasi</h3>
                <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:16px;">
                    Tinjau profil organisasi di atas sebelum mengambil keputusan.
                </p>

                <form method="POST" action="{{ route('admin.users.verify-organization', $org->id) }}" style="margin-bottom:10px;">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <button type="submit" class="ak-btn ak-btn-success" style="width:100%; justify-content:center;"
                            onclick="return confirm('Verifikasi organisasi ini?')">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Setujui Verifikasi
                    </button>
                </form>

                <button type="button" onclick="document.getElementById('orgRejectForm').classList.toggle('hidden')"
                        class="ak-btn ak-btn-ghost" style="width:100%; justify-content:center; color:var(--color-danger); border-color:var(--color-danger);">
                    Tolak Verifikasi
                </button>

                <div id="orgRejectForm" class="hidden" style="margin-top:14px; padding-top:14px; border-top:1px solid var(--color-warning);">
                    <form method="POST" action="{{ route('admin.users.verify-organization', $org->id) }}">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <div class="ak-form-group" style="margin-bottom:12px;">
                            <label class="ak-label" for="rejection_reason_org">
                                Alasan Penolakan <span class="required">*</span>
                            </label>
                            <textarea name="rejection_reason" id="rejection_reason_org" class="ak-textarea" rows="4"
                                      placeholder="Contoh: Dokumen akta pendirian organisasi tidak dilampirkan. Silakan lengkapi dokumen dan ajukan ulang."
                                      required></textarea>
                            <span class="ak-input-hint">Alasan ini dikirim ke organisasi melalui notifikasi.</span>
                        </div>
                        <button type="submit" class="ak-btn ak-btn-danger" style="width:100%; justify-content:center;"
                                onclick="return confirm('Tolak verifikasi organisasi ini?')">
                            Konfirmasi Penolakan
                        </button>
                    </form>
                </div>
            </div>

        @elseif($org && $org->verification_status === 'verified')
            <div class="ak-alert ak-alert-success">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <div style="font-weight:600;">Sudah Terverifikasi</div>
                    @if($org->verified_at)
                        <div style="font-size:0.8rem; margin-top:2px;">Sejak {{ \Carbon\Carbon::parse($org->verified_at)->format('d M Y') }}</div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Toggle aktif akun --}}
        @if($user->role !== 'admin')
            <div class="ak-card-flat">
                <h3 style="font-size:0.95rem; margin-bottom:4px;">Status Akun</h3>
                <p style="font-size:0.8rem; color:var(--color-ink-muted); margin-bottom:14px;">
                    {{ $user->is_active ? 'Akun sedang aktif. Pengguna dapat login dan menggunakan platform.' : 'Akun sedang dinonaktifkan. Pengguna tidak dapat login.' }}
                </p>
                <button type="button"
                        onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }}, this)"
                        class="ak-btn ak-btn-sm {{ $user->is_active ? 'ak-btn-danger' : 'ak-btn-success' }}"
                        style="width:100%; justify-content:center;">
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