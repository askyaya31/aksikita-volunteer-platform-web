@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@push('styles')
<style>
/* ─── Table base ──────────────────────────────────────────────── */
.user-table { width: 100%; border-collapse: collapse; }

.user-table th {
    padding: 9px 14px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: var(--color-ink-muted);
    border-bottom: 1px solid var(--color-border);
    text-align: left;
    white-space: nowrap;
    background: transparent;
}

.user-table td {
    padding: 11px 14px;
    border-bottom: 1px solid var(--color-border-soft);
    vertical-align: middle;
    text-align: left;
}

.user-table tbody tr:last-child td { border-bottom: none; }
.user-table tbody tr:hover td { background: var(--color-bg); }
.user-table tbody tr.pending-row:hover td { background: var(--color-blue-200); }

/* ─── Avatar ──────────────────────────────────────────────────── */
.u-avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--color-border);
    flex-shrink: 0;
    display: block;
}

.u-avatar-mono {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--color-border);
    background: var(--color-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: var(--color-navy);
    font-family: var(--font-display);
    flex-shrink: 0;
    letter-spacing: 0;
}

/* ─── Status indicator ────────────────────────────────────────── */
.u-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--color-ink-muted);
}
.u-status__dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    flex-shrink: 0;
}
.u-status__dot--active  { background: var(--color-success); }
.u-status__dot--inactive { background: var(--color-border); }

/* ─── Verif text (no badge/chip) ─────────────────────────────── */
.u-verif-verified { color: var(--color-success); font-weight: 500; font-size: 0.8rem; }
.u-verif-pending  { color: var(--color-warning); font-weight: 500; font-size: 0.8rem; }
.u-verif-rejected { color: var(--color-danger); font-weight: 500; font-size: 0.8rem; }
.u-verif-none     { color: var(--color-border); font-size: 0.8rem; }

/* ─── Role text ───────────────────────────────────────────────── */
.u-role { font-size: 0.8rem; color: var(--color-ink-soft); }

/* ─── Action menu ─────────────────────────────────────────────── */
.action-menu-wrap { position: relative; display: inline-block; }

.action-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: calc(100% + 4px);
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    box-shadow: 0 4px 16px rgb(0 0 0 / 0.1);
    min-width: 156px;
    z-index: 100;
    overflow: hidden;
}

.action-dropdown a,
.action-dropdown button {
    display: block;
    width: 100%;
    padding: 8px 14px;
    font-size: 0.8125rem;
    text-align: left;
    border: none;
    background: none;
    cursor: pointer;
    color: var(--color-ink);
    text-decoration: none;
    font-family: var(--font-body);
    line-height: 1.4;
    transition: background 0.1s;
}
.action-dropdown a:hover,
.action-dropdown button:hover { background: var(--color-bg); }
.action-dropdown .danger  { color: var(--color-danger); }
.action-dropdown .success { color: var(--color-success); }
.action-dropdown .divider { height: 1px; background: var(--color-border); margin: 2px 0; }

.dot-btn {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1px solid transparent;
    background: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-ink-muted);
    transition: all 0.15s;
}
.dot-btn:hover {
    border-color: var(--color-border);
    background: var(--color-bg);
    color: var(--color-ink);
}
</style>
@endpush

@section('content')

<div style="margin-bottom:24px;">
    <h1 style="font-size:1.25rem; font-weight:700; margin-bottom:2px; color:var(--color-ink);">Kelola Pengguna</h1>
    <p style="margin:0; font-size:0.85rem; color:var(--color-ink-muted);">Akun volunteer, organisasi, dan proses verifikasi.</p>
</div>

{{-- Tab --}}
<div style="display:flex; border-bottom:1px solid var(--color-border); margin-bottom:20px;">
    @php
        $tabs = ['semua' => 'Semua Pengguna', 'volunteer' => 'Volunteer', 'organisasi' => 'Organisasi'];
    @endphp
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.users') }}?tab={{ $key }}{{ request('search') ? '&search='.urlencode(request('search')) : '' }}"
           style="padding:8px 14px; font-size:0.8125rem; font-weight:{{ $tab === $key ? '600' : '400' }}; border-bottom:2px solid {{ $tab === $key ? 'var(--color-navy)' : 'transparent' }}; color:{{ $tab === $key ? 'var(--color-navy)' : 'var(--color-ink-muted)' }}; text-decoration:none; margin-bottom:-1px; white-space:nowrap; transition:color 0.12s;">
            {{ $label }}
        </a>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users') }}" style="margin-bottom:20px;">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <div style="display:flex; gap:8px; max-width:380px;">
        <div style="position:relative; flex:1;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--color-ink-muted); pointer-events:none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" class="ak-input" placeholder="Cari nama atau email..."
                   value="{{ request('search') }}" style="padding-left:32px; font-size:0.875rem; height:38px;">
        </div>
        <button type="submit" class="ak-btn ak-btn-primary" style="font-size:0.875rem; height:38px; padding-inline:16px;">Cari</button>
        @if(request('search'))
            <a href="{{ route('admin.users') }}?tab={{ $tab }}" class="ak-btn ak-btn-ghost" style="font-size:0.875rem; height:38px;">Reset</a>
        @endif
    </div>
</form>

{{-- Table --}}
<div style="border:1px solid var(--color-border); border-radius:10px; overflow:hidden;">
    <table class="user-table">
        <thead>
            <tr>
                <th style="width:220px;">Pengguna</th>
                @if($tab !== 'volunteer')<th style="width:100px;">Role</th>@endif
                <th style="width:90px;">Status</th>
                @if($tab !== 'volunteer')<th style="width:120px;">Verifikasi</th>@endif
                <th style="width:110px;">Bergabung</th>
                <th style="width:40px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    // Pilih avatar: volunteer pakai volunteerProfile->avatar, organisasi pakai organizationProfile->logo, fallback user->avatar
                    $avatarSrc = null;
                    if ($user->role === 'volunteer' && $user->volunteerProfile?->avatar) {
                        $avatarSrc = asset('storage/' . $user->volunteerProfile->avatar);
                    } elseif ($user->role === 'organization' && $user->organizationProfile?->logo) {
                        $avatarSrc = asset('storage/' . $user->organizationProfile->logo);
                    } elseif ($user->avatar) {
                        $avatarSrc = $user->avatar; // bisa Google URL langsung
                    }
                @endphp

                <tr>
                    {{-- Kolom Pengguna: avatar lebih besar + nama + email --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px; min-width:0;">
                            @if($avatarSrc)
                                <img src="{{ $avatarSrc }}" alt="{{ $user->name }}" class="u-avatar">
                            @else
                                <div class="u-avatar-mono">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            @endif
                            <div style="min-width:0;">
                                <div style="font-size:0.875rem; font-weight:600; color:var(--color-ink); line-height:1.3; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">{{ $user->name }}</div>
                                <div style="font-size:0.775rem; color:var(--color-ink-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    @if($tab !== 'volunteer')
                    <td>
                        <span class="u-role">
                            @if($user->role === 'volunteer') Volunteer
                            @elseif($user->role === 'organization') Organisasi
                            @elseif($user->role === 'admin') Admin
                            @endif
                        </span>
                    </td>
                    @endif

                    {{-- Status: dot + teks, tanpa chip --}}
                    <td>
                        <span class="u-status">
                            <span class="u-status__dot {{ $user->is_active ? 'u-status__dot--active' : 'u-status__dot--inactive' }}"></span>
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    @if($tab !== 'volunteer')
                    <td>
                        @if($user->role === 'organization' && $user->organizationProfile)
                            @php $vs = $user->organizationProfile->verification_status; @endphp
                            @if($vs === 'verified')
                                <span class="u-verif-verified">Terverifikasi</span>
                            @elseif($vs === 'pending')
                                <span class="u-verif-pending">Pending</span>
                            @elseif($vs === 'rejected')
                                <span class="u-verif-rejected">Ditolak</span>
                            @else
                                <span class="u-verif-none">—</span>
                            @endif
                        @else
                            <span class="u-verif-none">—</span>
                        @endif
                    </td>
                    @endif

                    <td style="color:var(--color-ink-muted); font-size:0.8rem; white-space:nowrap;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td style="text-align:right; padding-right:12px;">
                        @if($user->role !== 'admin')
                        <div class="action-menu-wrap">
                            <button class="dot-btn" onclick="toggleMenu(this)" title="Aksi">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="5"  r="1.8"/>
                                    <circle cx="12" cy="12" r="1.8"/>
                                    <circle cx="12" cy="19" r="1.8"/>
                                </svg>
                            </button>
                            <div class="action-dropdown">
                                @if($user->role === 'volunteer')
                                    <a href="{{ route('admin.volunteers.show', $user->id) }}">Lihat Detail</a>
                                @elseif($user->role === 'organization')
                                    <a href="{{ route('admin.organizations.show', $user->id) }}">Lihat Detail</a>
                                @endif
                                <div class="divider"></div>
                                <button type="button"
                                        class="{{ $user->is_active ? 'danger' : 'success' }}"
                                        onclick="toggleUserActive({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})">
                                    {{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}
                                </button>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>

                {{-- Banner verifikasi pending — tetap amber tapi lebih subtle --}}
                @if($user->role === 'organization' && $user->organizationProfile?->verification_status === 'pending')
                <tr class="pending-row">
                    <td colspan="{{ $tab === 'volunteer' ? 4 : 6 }}"
                        style="padding:8px 14px 8px 60px; background:var( --color-blue-ghost); border-left:2px solid var(--color-blue-light); border-bottom:1px solid var(--color-bg);">
                        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                            <div style="flex:1; min-width:160px;">
                                <span style="font-size:0.775rem; font-weight:600; color:var(--color-ink-muted);">Menunggu verifikasi</span>
                                <span style="font-size:0.775rem; color:var(--color-ink-muted); margin-left:6px;">
                                    {{ $user->organizationProfile->organization_name }}{{ $user->organizationProfile->city ? ' · '.$user->organizationProfile->city : '' }}
                                </span>
                            </div>
                            <div style="display:flex; gap:6px;">
                                <a href="{{ route('admin.organizations.show', $user->id) }}"
                                style="padding:4px 10px; font-size:0.775rem; border:1px solid var(--color-navy); border-radius:6px; color:var(--color-ink-soft); text-decoration:none; background:var(--color-surface);">
                                    Lihat Profil
                                </a>
                                <button onclick="openVerifyModal({{ $user->organizationProfile->id }}, '{{ addslashes($user->organizationProfile->organization_name) }}')"
                                        style="padding:4px 10px; font-size:0.775rem; border:none; border-radius:6px; background:var(--color-blue); color:#fff; cursor:pointer; font-family:var(--font-body);">
                                    Verifikasi
                                </button>
                                <button onclick="openRejectModal({{ $user->organizationProfile->id }}, '{{ addslashes($user->organizationProfile->organization_name) }}')"
                                        style="padding:4px 10px; font-size:0.775rem; border:1px solid var(--color-danger); border-radius:6px; color:#fff; background:var(--color-danger);; cursor:pointer; font-family:var(--font-body);">
                                    Tolak
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif

            @empty
                <tr>
                    <td colspan="{{ $tab === 'volunteer' ? 4 : 6 }}" style="padding:0; border:none;">
                        <div class="ak-empty-state">
                            <div class="ak-empty-state__icon">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3>Tidak ada pengguna</h3>
                            <p>
                                @if(request('search'))
                                    Tidak ada yang cocok dengan "{{ request('search') }}".
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
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; flex-wrap:wrap; gap:10px;">
        <div style="font-size:0.8rem; color:var(--color-ink-muted);">
            {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pengguna
        </div>
        <div class="ak-pagination">
            @if($users->onFirstPage())
                <span class="disabled"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></span>
            @else
                <a href="{{ $users->previousPageUrl() }}"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></a>
            @endif
            @foreach($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
                @if($page === $users->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></a>
            @else
                <span class="disabled"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></span>
            @endif
        </div>
    </div>
@endif

{{-- Modal Verifikasi --}}
<div id="verifyModal" style="display:none; position:fixed; inset:0; z-index:200; background:rgb(0 0 0/0.4); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--color-surface); border-radius:14px; padding:26px; max-width:400px; width:100%; box-shadow:var(--shadow-lg);">
        <h3 style="font-size:0.975rem; margin-bottom:6px;">Setujui Verifikasi Organisasi</h3>
        <p style="font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:20px;" id="verifyModalDesc"></p>
        <form id="verifyForm" method="POST">
            @csrf
            <input type="hidden" name="action" value="approve">
            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" onclick="closeModal('verifyModal')" class="ak-btn ak-btn-ghost">Batal</button>
                <button type="submit" class="ak-btn ak-btn-success">Setujui</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tolak --}}
<div id="rejectModal" style="display:none; position:fixed; inset:0; z-index:200; background:rgb(0 0 0/0.4); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--color-surface); border-radius:14px; padding:26px; max-width:440px; width:100%; box-shadow:var(--shadow-lg);">
        <h3 style="font-size:0.975rem; margin-bottom:6px;">Tolak Verifikasi Organisasi</h3>
        <p style="font-size:0.85rem; color:var(--color-ink-muted); margin-bottom:16px;" id="rejectModalDesc"></p>
        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="action" value="reject">
            <div class="ak-form-group" style="margin-bottom:12px;">
                <label class="ak-label" for="modal_rejection_reason">Alasan Penolakan <span class="required">*</span></label>
                <textarea name="rejection_reason" id="modal_rejection_reason" class="ak-textarea" rows="4"
                          placeholder="Contoh: Dokumen yang dilampirkan tidak lengkap..." required></textarea>
                <span class="ak-input-hint">Dikirim ke organisasi melalui notifikasi.</span>
            </div>
            <div style="display:flex; gap:8px; justify-content:flex-end;">
                <button type="button" onclick="closeModal('rejectModal')" class="ak-btn ak-btn-ghost">Batal</button>
                <button type="submit" class="ak-btn ak-btn-danger">Konfirmasi Penolakan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleMenu(btn) {
    const wrap = btn.closest('.action-menu-wrap');
    const dd   = wrap.querySelector('.action-dropdown');
    const open = dd.style.display === 'block';
    document.querySelectorAll('.action-dropdown').forEach(d => d.style.display = 'none');
    if (!open) dd.style.display = 'block';
}

document.addEventListener('click', e => {
    if (!e.target.closest('.action-menu-wrap'))
        document.querySelectorAll('.action-dropdown').forEach(d => d.style.display = 'none');
});

function openVerifyModal(orgId, orgName) {
    document.getElementById('verifyModalDesc').textContent =
        `Anda akan memverifikasi "${orgName}". Setelah diverifikasi, mereka dapat mulai membuat kegiatan.`;
    document.getElementById('verifyForm').action = `/admin/users/organizations/${orgId}/verify`;
    document.getElementById('verifyModal').style.display = 'flex';
}

function openRejectModal(orgId, orgName) {
    document.getElementById('rejectModalDesc').textContent =
        `Berikan alasan penolakan untuk "${orgName}" yang dapat ditindaklanjuti.`;
    document.getElementById('rejectForm').action = `/admin/users/organizations/${orgId}/verify`;
    document.getElementById('modal_rejection_reason').value = '';
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeModal(id) { document.getElementById(id).style.display = 'none'; }

['verifyModal','rejectModal'].forEach(id =>
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    })
);

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal('verifyModal'); closeModal('rejectModal'); }
});

async function toggleUserActive(userId, currentlyActive) {
    if (!confirm(currentlyActive ? 'Nonaktifkan akun ini?' : 'Aktifkan kembali akun ini?')) return;
    document.querySelectorAll('.action-dropdown').forEach(d => d.style.display = 'none');
    try {
        const res = await fetch(`/admin/users/${userId}/toggle-active`, {
            method: 'PATCH',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '',
            },
        });
        const data = await res.json();
        if (res.ok) window.location.reload();
        else alert(data.message ?? 'Gagal mengubah status.');
    } catch { alert('Terjadi kesalahan.'); }
}
</script>
@endpush