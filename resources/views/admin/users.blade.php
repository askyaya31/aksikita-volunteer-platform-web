@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

<div class="ak-page-header">
    <div class="ak-flex-between" style="flex-wrap:wrap; gap:12px;">
        <div>
            <h1 style="font-size:1.5rem; margin-bottom:4px;">Kelola Pengguna</h1>
            <p style="margin:0; font-size:0.9rem;">Kelola akun volunteer dan organisasi, serta proses verifikasi organisasi baru.</p>
        </div>
    </div>
</div>

{{-- Tab --}}
<div style="display:flex; gap:4px; border-bottom:2px solid var(--color-border); margin-bottom:24px;">
    @php
        $tabs = ['semua' => 'Semua', 'volunteer' => 'Volunteer', 'organisasi' => 'Organisasi'];
    @endphp
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.users') }}?tab={{ $key }}{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
           style="padding:10px 18px; font-size:0.875rem; font-weight:600; white-space:nowrap; border-bottom:2px solid {{ $tab === $key ? 'var(--color-navy)' : 'transparent' }}; color:{{ $tab === $key ? 'var(--color-navy)' : 'var(--color-ink-muted)' }}; text-decoration:none; margin-bottom:-2px; transition:all 0.15s;">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users') }}" style="margin-bottom:20px;">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div style="display:flex; gap:8px; max-width:480px;">
        <div style="position:relative; flex:1;">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--color-ink-muted);">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="ak-input" placeholder="Cari nama atau email..." value="{{ request('search') }}"
                   style="padding-left:40px;">
        </div>
        <button type="submit" class="ak-btn ak-btn-primary">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.users') }}?tab={{ $tab }}" class="ak-btn ak-btn-ghost">Reset</a>
        @endif
    </div>
</form>

{{-- Table --}}
<div class="ak-table-wrapper">
    <table class="ak-table">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Role</th>
                <th>Status Akun</th>
                <th>Status Org</th>
                <th>Bergabung</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    {{-- Pengguna --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg, var(--color-navy) 0%, var(--color-blue) 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:13px; flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600; font-size:0.875rem; color:var(--color-ink);">{{ $user->name }}</div>
                                <div style="font-size:0.78rem; color:var(--color-ink-muted);">{{ $user->email }}</div>
                                @if($user->phone)
                                    <div style="font-size:0.78rem; color:var(--color-ink-muted);">{{ $user->phone }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Role --}}
                    <td>
                        @if($user->role === 'volunteer')
                            <span class="ak-badge ak-badge-blue">Volunteer</span>
                        @elseif($user->role === 'organization')
                            <span class="ak-badge ak-badge-navy">Organisasi</span>
                        @elseif($user->role === 'admin')
                            <span class="ak-badge ak-badge-gray">Admin</span>
                        @endif
                    </td>

                    {{-- Status akun --}}
                    <td>
                        @if($user->is_active)
                            <span class="ak-badge ak-badge-success">Aktif</span>
                        @else
                            <span class="ak-badge ak-badge-danger">Nonaktif</span>
                        @endif
                    </td>

                    {{-- Status organisasi --}}
                    <td>
                        @if($user->role === 'organization' && $user->organizationProfile)
                            @php
                                $vs = $user->organizationProfile->verification_status;
                                $vMap = [
                                    'pending'  => ['Pending', 'ak-badge-warning'],
                                    'verified' => ['Terverifikasi', 'ak-badge-success'],
                                    'rejected' => ['Ditolak', 'ak-badge-danger'],
                                ];
                                [$vLabel, $vClass] = $vMap[$vs] ?? [$vs, 'ak-badge-gray'];
                            @endphp
                            <span class="ak-badge {{ $vClass }}">{{ $vLabel }}</span>
                        @else
                            <span style="font-size:0.8rem; color:var(--color-ink-muted);">—</span>
                        @endif
                    </td>

                    {{-- Bergabung --}}
                    <td>
                        <span style="font-size:0.8rem; color:var(--color-ink-muted);">{{ $user->created_at->format('d M Y') }}</span>
                    </td>

                    {{-- Aksi --}}
                    <td style="text-align:right;">
                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:6px; flex-wrap:wrap;">

                            {{-- Lihat profil detail --}}
                            @if($user->role === 'volunteer')
                                <a href="{{ route('admin.volunteers.show', $user->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                                    Detail
                                </a>
                            @elseif($user->role === 'organization')
                                <a href="{{ route('admin.organizations.show', $user->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                                    Detail
                                </a>
                            @endif

                            {{-- Toggle aktif/nonaktif — hanya untuk non-admin, via API route --}}
                            @if($user->role !== 'admin')
                                <button type="button"
                                        class="ak-btn ak-btn-sm {{ $user->is_active ? 'ak-btn-ghost' : 'ak-btn-success' }}"
                                        onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }}, this)"
                                        title="{{ $user->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            @endif

                        </div>
                    </td>
                </tr>

                {{-- Baris verifikasi org (hanya untuk org pending) --}}
                @if($user->role === 'organization' && $user->organizationProfile?->verification_status === 'pending')
                    <tr style="background:var(--color-warning-bg);">
                        <td colspan="6" style="padding:12px 20px;">
                            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                                <div style="flex:1; min-width:200px;">
                                    <div style="font-size:0.8rem; font-weight:600; color:#92400e; margin-bottom:2px;">
                                        Verifikasi Organisasi Diperlukan
                                    </div>
                                    <div style="font-size:0.78rem; color:#92400e;">
                                        {{ $user->organizationProfile->organization_name }} · {{ $user->organizationProfile->city }}, {{ $user->organizationProfile->province }}
                                    </div>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <a href="{{ route('admin.organizations.show', $user->id) }}" class="ak-btn ak-btn-ghost ak-btn-sm">
                                        Lihat Profil Lengkap
                                    </a>
                                    <button type="button"
                                            onclick="openVerifyModal({{ $user->organizationProfile->id }}, '{{ addslashes($user->organizationProfile->organization_name) }}')"
                                            class="ak-btn ak-btn-success ak-btn-sm">
                                        Verifikasi
                                    </button>
                                    <button type="button"
                                            onclick="openRejectModal({{ $user->organizationProfile->id }}, '{{ addslashes($user->organizationProfile->organization_name) }}')"
                                            class="ak-btn ak-btn-danger ak-btn-sm">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif

            @empty
                <tr>
                    <td colspan="6" style="padding:0; border:none;">
                        <div class="ak-empty-state">
                            <div class="ak-empty-state__icon">
                                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3>Tidak ada pengguna</h3>
                            <p>
                                @if(request('search'))
                                    Tidak ada pengguna yang cocok dengan "{{ request('search') }}".
                                @else
                                    Belum ada pengguna terdaftar.
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
@if($users->hasPages())
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; flex-wrap:wrap; gap:12px;">
        <div style="font-size:0.85rem; color:var(--color-ink-muted);">
            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
        </div>
        <div class="ak-pagination">
            @if($users->onFirstPage())
                <span class="disabled"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></span>
            @else
                <a href="{{ $users->previousPageUrl() }}"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></a>
            @endif
            @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                @if($page === $users->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
            @else
                <span class="disabled"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></span>
            @endif
        </div>
    </div>
@endif

<div id="verifyModal" style="display:none; position:fixed; inset:0; z-index:200; background:rgb(0 0 0/0.5); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--color-surface); border-radius:var(--radius-xl); padding:32px; max-width:440px; width:100%; box-shadow:var(--shadow-lg);">
        <h3 style="font-size:1.1rem; margin-bottom:8px;">Setujui Verifikasi Organisasi</h3>
        <p style="font-size:0.875rem; color:var(--color-ink-muted); margin-bottom:20px;" id="verifyModalDesc">
            Organisasi ini akan diverifikasi dan dapat mulai membuat kegiatan.
        </p>
        <form id="verifyForm" method="POST">
            @csrf
            <input type="hidden" name="action" value="approve">
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeModal('verifyModal')" class="ak-btn ak-btn-ghost">Batal</button>
                <button type="submit" class="ak-btn ak-btn-success">Setujui Verifikasi</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TOLAK ORGANISASI --}}
<div id="rejectModal" style="display:none; position:fixed; inset:0; z-index:200; background:rgb(0 0 0/0.5); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--color-surface); border-radius:var(--radius-xl); padding:32px; max-width:480px; width:100%; box-shadow:var(--shadow-lg);">
        <h3 style="font-size:1.1rem; margin-bottom:8px;">Tolak Verifikasi Organisasi</h3>
        <p style="font-size:0.875rem; color:var(--color-ink-muted); margin-bottom:20px;" id="rejectModalDesc">
            Berikan alasan penolakan yang jelas agar organisasi dapat memperbaiki dokumennya.
        </p>
        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="action" value="reject">
            <div class="ak-form-group" style="margin-bottom:16px;">
                <label class="ak-label" for="modal_rejection_reason">
                    Alasan Penolakan <span class="required">*</span>
                </label>
                <textarea name="rejection_reason" id="modal_rejection_reason" class="ak-textarea" rows="4"
                          placeholder="Contoh: Dokumen yang dilampirkan tidak lengkap. Mohon lampirkan akta pendirian organisasi dan NPWP yang masih berlaku."
                          required></textarea>
                <span class="ak-input-hint">Alasan ini akan dikirim ke organisasi melalui notifikasi.</span>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeModal('rejectModal')" class="ak-btn ak-btn-ghost">Batal</button>
                <button type="submit" class="ak-btn ak-btn-danger">Konfirmasi Penolakan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openVerifyModal(orgId, orgName) {
    document.getElementById('verifyModalDesc').textContent =
        `Anda akan memverifikasi organisasi "${orgName}". Setelah diverifikasi, mereka dapat mulai membuat kegiatan.`;
    document.getElementById('verifyForm').action = `/admin/users/organizations/${orgId}/verify`;
    const modal = document.getElementById('verifyModal');
    modal.style.display = 'flex';
}

function openRejectModal(orgId, orgName) {
    document.getElementById('rejectModalDesc').textContent =
        `Berikan alasan penolakan untuk organisasi "${orgName}" yang jelas dan dapat ditindaklanjuti.`;
    document.getElementById('rejectForm').action = `/admin/users/organizations/${orgId}/verify`;
    document.getElementById('modal_rejection_reason').value = '';
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Close modal saat klik backdrop
['verifyModal', 'rejectModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});

// Tutup modal dengan ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeModal('verifyModal');
        closeModal('rejectModal');
    }
});

// Toggle user active via API
async function toggleUserActive(userId, currentlyActive, btn) {
    if (!confirm(currentlyActive
        ? 'Nonaktifkan akun pengguna ini? Mereka tidak akan bisa login.'
        : 'Aktifkan kembali akun pengguna ini?'
    )) return;

    btn.disabled = true;
    btn.textContent = '...';

    try {
        const res = await fetch(`/api/admin/users/${userId}/toggle-active`, {
            method: 'PATCH',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
            },
        });
        const data = await res.json();
        if (res.ok) {
            window.location.reload();
        } else {
            alert(data.message ?? 'Gagal mengubah status.');
            btn.disabled = false;
            btn.textContent = currentlyActive ? 'Nonaktifkan' : 'Aktifkan';
        }
    } catch {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btn.disabled = false;
        btn.textContent = currentlyActive ? 'Nonaktifkan' : 'Aktifkan';
    }
}
</script>
@endpush